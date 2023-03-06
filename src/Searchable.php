<?php

namespace Cblink\Service\FormSchema;

use Cblink\Service\FormSchema\Consts\FormSearchConst;
use Hyperf\Utils\Contracts\Arrayable;

/**
 * @method $this label(string $label)
 * @method $this sort(int $sort)
 * @method $this group(string $group = 'default')
 */
class Searchable implements Arrayable
{

    /**
     * @var
     */
    protected $payload = [
        'sort' =>  999,
        'type' => FormSearchConst::TYPE_EQ,
    ];

    /**
     * @var array
     */
    protected $drop = false;

    public function __construct(string $field)
    {
        $this->payload['field'] = $field;
    }

    /**
     * @return mixed
     */
    public function field()
    {
        return $this->payload['field'];
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
     * @param string $type
     * @return $this
     */
    public function type(string $type = FormSearchConst::TYPE_EQ)
    {
        $this->payload['type'] = $type;
        return $this;
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

        if (! in_array($name, ['label', 'sort', 'group'])) {
            throw new \InvalidArgumentException(sprintf('%s method not found!', $name));
        }

        $this->payload[$name] = $arguments[0];

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->payload;
    }
}