<?php

namespace Alex\Annotations\Services\Validate;

use Illuminate\Http\Request;

class Validate
{
    protected string $rule = '';
    protected string $message = '';
    protected Request $request;
    protected static $booted = false;

    public function __construct()
    {
        $this->ifNotBooted();
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    protected function ifNotBooted()
    {
        if (! self::$booted) {
            $this->boot();
            self::$booted = true;
        }
    }

    protected function boot()
    {

    }
}
