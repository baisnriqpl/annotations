<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use ReflectionProperty;
use Attribute;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class RequiredIf extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'required_if';
    protected string|array $if = [];

    public function __construct(string|array $if = [], string $message = '')
    {
        $this->if = $if;
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
        $if = '';
        if (gettype($this->if) == 'array') {
            foreach ($this->if as $key => $val) {
                $if = $key . ',' . $val . ',';
            }
            $if = rtrim($if, ',');
        }
        return [[$name => $this->rule . ':' . $if], $messages];
    }
}
