<?php

namespace Alex\Annotations\Interfaces;
use ReflectionProperty;

interface ServicePropertyInterface
{
    public function handle(ReflectionProperty $property, Object $class);
}
