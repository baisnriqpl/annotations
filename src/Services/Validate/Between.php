<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Between extends Validate implements ServicePropertyInterface
{
    protected int $min;
    protected int $max;
    protected string $rule = 'between';

    public function __construct(int $min = 0, int $max = 0, string $message = '')
    {
        $this->min = $min;
        $this->max = $max;
        $this->message = $message;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        return [[$name => $this->rule . ':' . $this->min . ',' . $this->max], $messages];
    }
}
