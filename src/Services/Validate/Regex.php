<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Regex extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'regex';
    protected string $regex = '';

    public function __construct(string $regex = '', string $message = '')
    {
        $this->regex = $regex;
        $this->message = $message;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        return [[$name => [$this->rule .':' . $this->regex]], $messages];
    }
}
