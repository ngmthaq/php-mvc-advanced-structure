<?php

use App\Controllers\V1\WelcomeController;

return [
    "/v1/hello" => [WelcomeController::class, "helloPost"],
    "/v1/users/insert" => [WelcomeController::class, "insertUser"],
    "/v1/users/update" => [WelcomeController::class, "updateUser"],
    "/v1/users/delete" => [WelcomeController::class, "deleteUser"],
    "/v1/login" => [WelcomeController::class, "login"],
    "/v1/logout" => [WelcomeController::class, "logout", ["auth"]],
    "/v1/demo" => [WelcomeController::class, "demo"],
];
