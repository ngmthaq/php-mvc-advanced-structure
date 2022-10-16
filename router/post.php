<?php

use Src\Controllers\V1\WelcomeController;

return [
    "/api/v1/hello" => [WelcomeController::class, "helloPost"],
    "/api/v1/users/insert" => [WelcomeController::class, "insertUser"],
    "/api/v1/users/update" => [WelcomeController::class, "updateUser"],
    "/api/v1/users/delete" => [WelcomeController::class, "deleteUser"],
    "/api/v1/login" => [WelcomeController::class, "login"],
    "/api/v1/logout" => [WelcomeController::class, "logout", ["auth"]],
];
