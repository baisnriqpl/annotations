<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use ReflectionProperty;
use Attribute;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Required extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'required';

    public function __construct(string $message = '')
    {
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
        return [[$name => $this->rule], $messages];
    }
}
