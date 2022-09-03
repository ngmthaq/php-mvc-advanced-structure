<?php

namespace Src\Middlewares;

use Core\Middleware\Middleware;

class TrimString extends Middleware
{
    public function handle(): bool
    {
        return true;
    }
}
