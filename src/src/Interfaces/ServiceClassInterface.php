<?php

namespace Alex\Annotations\Interfaces;
use Attribute;
use ReflectionClass;
use ReflectionAttribute;

#[Attribute(Attribute::TARGET_CLASS)]
interface ServiceClassInterface
{
    public function handle(ReflectionClass $reflection, Object $class, ReflectionAttribute $attr);
}
