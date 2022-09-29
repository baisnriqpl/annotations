<?php

namespace Alex\Annotations\Services\Validate;
use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsInteger extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'integer';

    public function __construct(string $message = '')
    {
        $this->message = $message;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        return [[$name => $this->rule], $messages];
    }
}
