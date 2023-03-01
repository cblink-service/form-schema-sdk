<?php

namespace Cblink\Service\FormSchema;
use Hyperf\Utils\Contracts\Arrayable;

/**
 * @method $this label(string $label)
 * @method $this component(string $component)
 * @method $this type(string $type)
 * @method $this default($default)
 * @method $this rules(array $rules)
 * @method $this sort(int $sort)
 * @method $this ext(array $ext)
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
        if (count($arguments) < 1) {
            throw new \InvalidArgumentException(sprintf('%s At least 1 parameter!', $name));
        }

        if (! in_array($name, ['label', 'component', 'type', 'default', 'rules', 'sort', 'ext'])) {
            throw new \InvalidArgumentException(sprintf('%s At least 1 parameter!', $name));
        }

        $this->payload[$name] = $arguments[0];

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