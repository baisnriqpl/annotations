<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use ReflectionProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Custom extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'custom';
    protected string $param;

    public function __construct(string $object, string $message = '')
    {
        $this->param = $object;
        $this->message = $message;
        parent::__construct();
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        $rule = $this->rule . strtolower(Str::random(16));
        if ($this->message) {
            $messages[$name . '.' . $rule] = $this->message;
        }
        if (class_exists($this->param)) {
            $class = app()->make($this->param);
            if ($class instanceof CustomInterface) {
                Validator::extend($rule, $class->handle());
            }
        }
        return [[$name => $rule], $messages];
    }
}
