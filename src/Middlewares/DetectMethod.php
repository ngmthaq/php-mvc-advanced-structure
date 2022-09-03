<?php

namespace Src\Middlewares;

use Core\Middleware\Middleware;

class DetectMethod extends Middleware
{
    public function handle(): bool
    {
        $requestMethod = strtolower($_SERVER["REQUEST_METHOD"]);
        $configMethod = strtolower($this->req->configs()["method"]);
        if (strcmp($requestMethod, $configMethod) !== 0) {
            $this->res->json(["error" => "Method Not Allowed"], 405);
            return false;
        }

        return true;
    }
}
