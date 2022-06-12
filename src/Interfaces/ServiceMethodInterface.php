<?php

namespace Alex\Annotations\Interfaces;
use ReflectionMethod;
use ReflectionAttribute;

interface ServiceMethodInterface
{
    public function handle(ReflectionMethod $method, Object $class, ReflectionAttribute $attr);
}