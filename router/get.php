<?php

use Src\Controllers\V1\WelcomeController;

return [
    "/api/v1/hello" => [WelcomeController::class, "hello"],
    "/api/v1/users" => [WelcomeController::class, "users"],
    "/api/v1/demo" => [WelcomeController::class, "demo"],
];
