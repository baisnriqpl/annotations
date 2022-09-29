<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Max extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'max';
    protected int $max = 0;

    public function __construct(int $max = 0, string $message = '')
    {
        $this->message = $message;
        $this->max = $max;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        return [[$name => $this->rule . ':' . $this->max], $messages];
    }
}
