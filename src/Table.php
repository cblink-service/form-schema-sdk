<?php

namespace Cblink\Service\FormSchema;

use Hyperf\Utils\Contracts\Arrayable;

class Table
{
    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $name;

    protected $search = [];
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
     * @param string $updateBy
     * @return Field
     */
    public function field($field, string $updateBy = 'field')
    {
        $this->fields[$field] = new Field($field, $updateBy);

        return $this->fields[$field];
    }

    /**
     * @param $field
     * @return Searchable
     */
    public function searchable($field)
    {
        $this->search[$field] = new Searchable($field);

        return $this->search[$field];
    }

    public function getTable()
    {
        return [
            'code' => $this->code,
            'name' => $this->name,
        ];
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getSearchable()
    {
        return $this->search;
    }
}