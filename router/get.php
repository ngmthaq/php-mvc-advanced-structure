<?php

use Src\Controllers\V1\WelcomeController;

return [
    "/" => [WelcomeController::class, "index"],
    "/api/v1/hello" => [WelcomeController::class, "hello"],
    "/api/v1/users" => [WelcomeController::class, "users"],
    "/api/v1/demo" => [WelcomeController::class, "demo"],
    "/api/v1/users/check" => [WelcomeController::class, "checkUser"],
];
