<?php

    namespace Alex\Annotations\Services;

    use Alex\Annotations\Interfaces\ServiceMethodInterface;
    use Attribute;
    use ReflectionMethod;
    use ReflectionAttribute;

    #[Attribute(Attribute::TARGET_METHOD)]
    class Autoload implements ServiceMethodInterface
    {
        public function handle(ReflectionMethod $method, Object $class, ReflectionAttribute $attr)
        {
            $params = $method->getParameters();
            $data = $attr->getArguments();
            foreach ($params as $param) {
                if ($type = $param->getType()) {
                    $name = $type->getName();
                    if (class_exists($name)) {
                        $data[$param->getPosition()] = new $name;
                    }
                }
            }
            $method->setAccessible(true);
            $method->invoke($class, ...$data);
        }
    }
