<?php

namespace Alex\Annotations\Services\Validate;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use Illuminate\Support\Facades\Validator;
use ReflectionProperty;
use Exception;

#[Attribute(Attribute::TARGET_PROPERTY)]
class RequiredWithout extends Validate implements ServicePropertyInterface
{
    protected string $rule = 'required_without';
    protected string|array $params = '';

    public function __construct(string|array $params = '', string $message = '')
    {
        $this->params = $params;
        $this->message = $message;
    }

    public function handle(ReflectionProperty $property, object $class)
    {
        $name = $property->getName();
        $messages = [];
        if ($this->message) {
            $messages[$name . '.' . $this->rule] = $this->message;
        }
        $params = gettype($this->params) == 'array' ? implode(',', $this->params) : $this->params;
        return [[$name => $this->rule . ':' . $params], $messages];
    }
}
