<?php

namespace Alex\Annotations\Services\Validate;
use Closure;

interface CustomInterface
{
    public function handle() : Closure;
}
