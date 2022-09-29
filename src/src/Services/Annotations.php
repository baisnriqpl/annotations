<?php

    namespace Alex\Annotations\Services;

    class Annotations
    {
        protected static $binds = [];
        protected static $instances = [];

        public static function bind($binds)
        {
            self::$binds = $binds;
        }

        public static function get($key)
        {
            if (! isset(self::$instances[$key]) && in_array($key, self::$binds)) {
                self::$instances[$key] = app()->make($key);
            }
            return self::$instances[$key];
        }

        public static function has($key)
        {
            return in_array($key, self::$binds);
        }

        public static function register($class)
        {
            $reflection = new \ReflectionClass($class);
            $classAttrs = $reflection->getAttributes();
            foreach ($classAttrs as $classAttr) {
                $name = $classAttr->getName();
                if (self::has($name)) {
                    self::get($name)->handle($reflection, $class, $classAttr);
                }
            }
            $properties = $reflection->getProperties();
            foreach ($properties as $property) {
                $propertyAttrs = $property->getAttributes();
                foreach ($propertyAttrs as $propertyAttr) {
                    $name = $propertyAttr->getName();
                    if (self::has($name)) {
                        self::get($name)->handle($property, $class, $propertyAttr);
                    }
                }
            }
            $methods = $reflection->getMethods();
            foreach ($methods as $method) {
                $methodAttrs = $method->getAttributes();
                foreach ($methodAttrs as $methodAttr) {
                    $name = $methodAttr->getName();
                    if (self::has($name)) {
                        self::get($name)->handle($method, $class, $methodAttr);
                    }
                }
            }
        }
        
        public static function extends(array $binds)
        {
            self::$binds = array_merge(self::$binds, $binds);
        }
    }
