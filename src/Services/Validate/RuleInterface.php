<?php

namespace Alex\Annotations\Services\Validate;

use Illuminate\Validation\Rule as Base;

interface RuleInterface
{
    public function handle(Base $rule);
}