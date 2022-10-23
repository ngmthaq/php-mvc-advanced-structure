<?php

use App\Controllers\V1\WelcomeController;

return [
    "/v1/hello" => [WelcomeController::class, "hello"],
    "/v1/users" => [WelcomeController::class, "users"],
    "/v1/users/check" => [WelcomeController::class, "checkUser"],
    "/v1/file" => [WelcomeController::class, "file"],
];
