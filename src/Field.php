<?php

namespace Cblink\Service\FormSchema;
use Cblink\Service\FormSchema\Consts\FormFieldConst;
use Hyperf\Utils\Contracts\Arrayable;

/**
 * @method $this label(string $label)
 * @method $this component(string $component)
 * @method $this default($default)
 * @method $this rules(array $rules)
 * @method $this sort(int $sort)
 * @method $this ext(array $ext)
 * @method $this data(array $data)
 */
class Field implements Arrayable
{
    /**
     * @var array
     */
    protected $payload = [
        'sort' => 999,
        'type' => FormFieldConst::TYPE_TRADE,
    ];

    /**
     * @var array
     */
    protected $drop = false;

    /**
     * @var mixed|string
     */
    protected $type;

    public function __construct($field, $updateBy = 'field')
    {
        $this->type = $updateBy;
        $this->payload[$this->isById() ? 'id': 'field'] = $field;
    }

    /**
     * @return mixed
     */
    public function field()
    {
        return $this->payload['field'] ?? null;
    }

    public function id()
    {
        return $this->payload['id'] ?? null;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function type(string $type = FormFieldConst::TYPE_TRADE)
    {
        $this->payload['type'] = $type;
        return $this;
    }

    /**
     * @return void
     */
    public function dropIf(bool $where = true)
    {
        $this->drop = $where;
    }

    public function isDrop()
    {
        return $this->drop;
    }

    /**
     * @return bool
     */
    public function isById()
    {
        return $this->type == 'id';
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (count($arguments) < 1) {
            throw new \InvalidArgumentException(sprintf('%s At least 1 parameter!', $name));
        }

        if (! in_array($name, ['label', 'component', 'default', 'rules', 'sort', 'ext', 'data'])) {
            throw new \InvalidArgumentException(sprintf('%s method not found!', $name));
        }

        $this->payload[$name] = $arguments[0];

        return $this;
    }

    /**
     * @return array|int[]
     */
    public function toArray(): array
    {
        return $this->payload;
    }
}