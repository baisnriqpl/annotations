<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use ReflectionProperty;
use Exception;

class IsString extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'string';

    public function __construct($message = '')
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
