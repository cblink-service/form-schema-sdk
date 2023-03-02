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

        return $this->dispatch($table);
    }


    /**
     * @param Table $table
     * @return array
     * @throws GuzzleException
     */
    protected function dispatch(Table $table)
    {
        // 查询表是否存在
        $form = $this->verify($this->app->form->show($table->getCode()));

        if (!$form) {
            $form = $this->response($this->app->form->store($table->getTable()));
        }

        $existsFields = Arr::pluck($this->response($this->app->field->index($table->getCode())),'id', 'field');
        $fields = [];

        /* @var Field $field */
        foreach ($table->getFields() as $field) {
            // 返回值
            $result = ['field' => $field->field(), 'payload' => $field->toArray()];
            // 删除搜索
            if ($field->isDrop() && array_key_exists($field->field(), $existsFields)) {
                $result['response'] = $this->app->field->destroy($table->getCode(), $existsFields[$field->field()]);
                $fields[] = $result;
                continue;
            }

            // 更新字段
            if (array_key_exists($field->field(), $existsFields)) {
                $result['response'] = $this->app->field->update($table->getCode(), $existsFields[$field->field()], $field->toArray());
                $fields[] = $result;
                continue;
            }

            // 创建搜索项
            $result['response'] = $this->app->field->store($table->getCode(), $field->toArray());
            $fields[] = $result;
        }

        $existsSearch = Arr::pluck($this->response($this->app->search->index($table->getCode())), 'id', 'field');

        $searchable = [];

        /* @var Searchable $search */
        foreach ($table->getSearchable() as $search) {
            // 返回值
            $result = ['field' => $search->field(), 'payload' => $search->toArray()];
            // 删除搜索
            if ($search->isDrop() && array_key_exists($search->field(), $existsSearch)) {
                $result['response'] = $this->app->search->destroy($table->getCode(), $existsSearch[$search->field()]);
                $searchable[] = $result;
                continue;
            }
            // 创建搜索项
            $result['response'] = $this->app->search->store($table->getCode(), $search->toArray());
            $searchable[] = $result;
        }


        return [
            'form' => $form,
            'fields' => $fields,
            'searchable' => $searchable,
        ];
    }


    /**
     * @param $code
     * @return bool
     * @throws GuzzleException
     */
    public function exists($code)
    {
        $response = $this->app->form->show($code);

        return $response['err_code'] == 0;
    }

    /**
     * @return bool
     */
    public function verify($data)
    {
        if (isset($data['err_code']) && is_int($data['err_code']) && $data['err_code'] == 0) {
            return $data['data'];
        }
        return false;
    }

    /**
     * @param $data
     * @param bool $throw
     * @return mixed
     */
    protected function response($data, bool $throw = true)
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