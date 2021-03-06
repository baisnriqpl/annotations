<?php

namespace Alex\Annotations\Services;

use Alex\Annotations\Interfaces\ServicePropertyInterface;
use Attribute;
use ReflectionProperty;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Autowired implements ServicePropertyInterface
{
    public function handle(ReflectionProperty $property, Object $class)
    {
        if ($type = $property->getType()) {
            $name = $type->getName();
            if (! class_exists($name)) {
                throw new \Exception($name . '不存在!');
            }
            $property->setAccessible(true);
            $property->setValue($class, app()->make($name));
        }
    }
}
