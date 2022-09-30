<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Gt extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'gt';
    protected int|string $param = '';

    public function __construct(int|string $param = '', string $message = '')
    {
        $this->param = $param;
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
        return [[$name => $this->rule . ':' . $this->param], $messages];
    }
}