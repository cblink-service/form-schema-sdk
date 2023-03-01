<?php

namespace Cblink\Service\FormSchema;

use Hyperf\Utils\Contracts\Arrayable;

class Table implements Arrayable
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $fields = [];

    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @param $comment
     * @return void
     */
    public function comment($comment)
    {
        $this->name = $comment;
    }

    /**
     * 设置字段
     *
     * @param $field
     * @return Field
     */
    public function field($field)
    {
        $this->fields[$field] = new Field($field);

        return $this->fields[$field];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'table' => [
                'code' => $this->code,
                'name' => $this->name,
            ],
            'fields' => $this->fields,
        ];
    }
}