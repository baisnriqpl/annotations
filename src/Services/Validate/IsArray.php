<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use ReflectionProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class IsArray extends Validate implements ServicePropertyInterface
{
    protected array $rules = [];
    protected array $messages = [];
    protected string $rule = 'array';

    public function __construct(string $message = '', array $rules = [], array $messages = [])
    {
        $this->message = $message;
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $value = $this->request->$name;
        $messages = [];
        $rules = [
            $name => $this->rule
        ];
        $messages = [
            $name . '.' . $this->rule => $this->message ?: ($name . ' type must be array.')
        ];
        foreach ($this->rules as $field => $rule) {
            $rules[$name . '.' . $field] = $rule;
        }
        foreach ($this->messages as $field => $message) {
            $messages[$name . '.' . $field] = $message;
        }

        return [$rules, $messages];
    }
}
