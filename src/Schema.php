<?php

namespace Cblink\Service\FormSchema;

use Closure;
use Cblink\Service\Form\Application;
use GuzzleHttp\Exception\GuzzleException;
use Hyperf\Utils\Arr;

class Schema
{
    protected $app = [];

    public function __construct(array $config = [])
    {
        $this->app = new Application($config);
    }

    /**
     * 创建表单
     *
     * @param $code
     * @param Closure $closure
     * @return array
     * @throws GuzzleException
     */
    public function create($code, Closure $closure)
    {
        $table = new Table($code);

        call_user_func($closure, $table);

        $data = $table->toArray();

        $form = $this->format($this->app->form->store($data['table']));

        $fields = array_map(function (Field $field) use ($form){
            return $this->format($this->app->field->store($form['code'], $field->toArray()));
        },$data['fields']);

        return [$form, $fields];
    }

    /**
     * 更新表单
     *
     * @param $code
     * @param Closure $closure
     * @return array
     * @throws GuzzleException
     */
    public function table($code, Closure $closure)
    {
        $table = new Table($code);

        call_user_func($closure, $table);

        $data = $table->toArray();

        $form = $this->format($this->app->form->show($code));

        $existsFields = Arr::pluck($this->format($this->app->field->index($code)), 'field');

        return array_map(function (Field $field) use ($form, $existsFields){

            // 如果字段存在，则进行修改，否则进行创建
            $result = in_array($field->field(), $existsFields) ?
                $this->app->field->updateByField($form['code'], $field->field(), $field->toArray()) :
                $this->app->field->store($form['code'], $field->toArray());

            return $this->format($result, false);
        },$data['fields']);
    }

    /**
     * @param $data
     * @param bool $throw
     * @return mixed
     */
    public function format($data, bool $throw = true)
    {
        // 请求成功了则返回
        if (isset($data['err_code']) && is_int($data['err_code']) && $data['err_code'] == 0) {
            return $data['data'];
        }

        if ($throw) {
            throw new \InvalidArgumentException(
                'request fail: %s (%s)',
                $data['err_msg'] ?? '',
                $data['err_code'] ?? ''
            );
        }

        return $data;
    }
}