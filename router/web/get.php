<?php

use App\Controllers\V1\WelcomeController;

return [
    "/" => [WelcomeController::class, "index"],
    "/demo" => [WelcomeController::class, "demo"],
];
