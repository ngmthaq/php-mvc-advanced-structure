<?php

namespace App\Middlewares;

use Core\Helpers\Helper;
use Core\Middleware\Middleware;
use Core\Protection\Csrf;

class CsrfProtection extends Middleware
{
    public function handle(): bool
    {
        $csrf = new Csrf();
        if (Helper::server("REQUEST_METHOD") === "GET") {
            return true;
        }

        if (Helper::server("REQUEST_METHOD") === "POST") {
            $csrfConfigsPath = __ROOT__ . "\\configs\\csrf.php";
            if (file_exists($csrfConfigsPath)) {
                $csrfConfigs = require($csrfConfigsPath);
                dd($_SERVER);
            }

            if ($csrf->validate($this->req->params("_token") ?? "")) {
                return true;
            }
        }

        isApi()
            ? $this->res->json(["error" => "Unauthorized", "details" => ["CSRF Protection"]], STATUS_UNAUTHORIZED)
            : $this->res->view("templates._401");

        return false;
    }
}
