<?php

namespace Src\Middlewares;

use Core\Middleware\Middleware;

class SessionStart extends Middleware
{
    public function handle(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return true;
    }
}
