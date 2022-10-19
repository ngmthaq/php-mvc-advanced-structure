<?php

use App\Controllers\V1\WelcomeController;

return [
    "/" => [WelcomeController::class, "index"],
    "/api/v1/hello" => [WelcomeController::class, "hello"],
    "/api/v1/users" => [WelcomeController::class, "users"],
    "/api/v1/users/check" => [WelcomeController::class, "checkUser"],
    "/api/v1/file" => [WelcomeController::class, "file"],
];
