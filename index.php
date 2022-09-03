<?php

use Core\App\App;
use Src\Controllers\V1\WelcomeController;

include_once("./vendor/autoload.php");

$app = new App();

// Api Ver 1
$app->get("/api/v1/hello", [WelcomeController::class, "hello"]);
$app->get("/api/v1/users", [WelcomeController::class, "users"]);

$app->run();
