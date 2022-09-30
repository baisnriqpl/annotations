<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use ReflectionProperty;
use Attribute;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class In extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'in';
    protected string|array $in = [];

    public function __construct(string|array $in = [], string $message = '')
    {
        $this->in = $in;
        $this->message = $message;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $value = $this->request->$name;
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        $in = gettype($this->in) == 'array' ? implode(',', $this->in) : $this->in;
        return [[$name => $this->rule . ':' . $in], $messages];
    }
}
