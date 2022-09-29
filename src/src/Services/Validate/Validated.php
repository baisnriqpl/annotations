<?php

namespace Alex\Annotations\Services\Validate;
use Alex\Annotations\Interfaces\ServiceClassInterface;
use Attribute;
use ReflectionClass;
use ReflectionAttribute;
use Illuminate\Support\Facades\Validator;
use Exception;

#[Attribute(Attribute::TARGET_CLASS)]
class Validated implements ServiceClassInterface
{
    protected static array $binds = [
        Required::class,
        Length::class,
        IsInteger::class,
        IsString::class,
        IsArray::class,
        Regex::class,
        Confirmation::class,
        Min::class,
        Max::class
    ];

    public function handle(ReflectionClass $reflection, Object $class, ReflectionAttribute $attr)
    {
        $request = app('request');
        $rules = [];
        $messages = [];
        $data = [];
        foreach ($reflection->getProperties() as $property) {
            foreach ($property->getAttributes() as $propertyAttr) {
                if ($attr = $this->getBind($propertyAttr->getName(), $propertyAttr->getArguments())) {
                    $attr->setRequest($request);
                    [$rule, $message] = $attr->handle($property, $class);
                    if (count($rule)) {
                        foreach ($rule as $key => $val) {
                            if (gettype($val) != 'array') {
                                $val = [$val];
                            }
                            if (! isset($rules[$key])) {
                                $rules[$key] = $val;
                            } else {
                                $rules[$key] = array_merge($rules[$key], $val);
                            }
                        }
                        $messages = array_merge($messages, $message);
                    }
                    $name = $property->getName();
                    $value = $request->$name;
                    if ($value !== null) {
                        $data[] = [
                            'property' => $property,
                            'value' => $value
                        ];
                    }
                }
            }
        }

        if (count($rules)) {
            $validate = Validator::make($request->all(), $rules, $messages);
            if ($validate->fails()) {
                throw new Exception($validate->errors()->first());
            }
        }
        foreach ($data as $value) {
            $value['property']->setAccessible(true);
            $value['property']->setValue($class, $value['value']);
        }
    }

    protected function getBind(string $bind, array $arguments)
    {
        return in_array($bind, self::$binds) ? new $bind(...$arguments) : null;
    }

    public function extend(string $class)
    {
        self::$binds[] = $class;
    }
}
