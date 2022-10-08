<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Exists extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'exists';
    protected string|object $param = '';

    public function __construct(string|object $rule = '', string $message = '')
    {
        $this->message = $message;
        $this->param = $rule;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        $rule = gettype($this->param) == 'string' ? $this->rule . ':' . $this->param : [$this->param];
        $rule = str_contains($this->param, '\\') && class_exists($this->param) ?
            app()->make($this->param)->handle(new Rule) :
            $this->rule . ':' . $this->param;
        return [[$name =>  $rule], $messages];
    }
}
