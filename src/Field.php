<?php

namespace Cblink\Service\FormSchema;
use Hyperf\Utils\Contracts\Arrayable;

/**
 * @method $this setLabel(string $label)
 * @method $this setComponent(string $component)
 * @method $this setType(string $type)
 * @method $this setDefault($default)
 * @method $this setRules(array $rules)
 * @method $this setSort(int $sort)
 * @method $this setExt(array $ext)
 */
class Field implements Arrayable
{
    /**
     * @var
     */
    protected $field;

    /**
     * @var array
     */
    protected $payload = [
        'sort' => 999,
    ];

    /**
     * @var array
     */
    protected $drop = false;

    public function __construct($field)
    {
        $this->field = $field;
    }

    /**
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (! str_starts_with($name, 'set')) {
            throw new \InvalidArgumentException(sprintf('method %s not found!', $name));
        }

        if (count($arguments) < 1) {
            throw new \InvalidArgumentException(sprintf('%s At least 1 parameter!', $name));
        }

        $key = strtolower(substr($name, 3));

        if (! in_array($key, ['label', 'component', 'type', 'default', 'rules', 'sort', 'ext'])) {
            throw new \InvalidArgumentException(sprintf('%s At least 1 parameter!', $name));
        }

        $this->payload[$key] = $arguments[0];

        return $this;
    }

    /**
     * @return void
     */
    public function drop()
    {
        $this->drop = true;
    }

    /**
     * @return mixed
     */
    public function field()
    {
        return $this->field;
    }

    public function isDrop()
    {
        return $this->drop;
    }

    /**
     * @return array|int[]
     */
    public function toArray(): array
    {
        return $this->payload;
    }
}