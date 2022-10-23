<?php

namespace App\Middlewares;

use Core\Helpers\Helper;
use Core\Middleware\Middleware;
use Core\Protection\Csrf;

class CsrfProtection extends Middleware
{
    public function handle(): bool
    {
        if (isApi()) {
            return true;
        }

        $csrf = new Csrf();
        if (Helper::server("REQUEST_METHOD") === "GET") {
            return true;
        }

        if (Helper::server("REQUEST_METHOD") === "POST") {
            if ($csrf->validate($this->req->params("_token") ?? "")) {
                return true;
            }
        }

        $this->res->view("templates._401", [], [], STATUS_UNAUTHORIZED);

        return false;
    }
}
