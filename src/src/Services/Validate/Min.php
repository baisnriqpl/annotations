<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Min extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'min';
    protected int $min = 0;

    public function __construct(int $min = 0, string $message = '')
    {
        $this->message = $message;
        $this->min = $min;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        return [[$name => $this->rule . ':' . $this->min], $messages];
    }
}
