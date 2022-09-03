<?php

use Core\App\App;
use Src\Controllers\V1\WelcomeController;

include_once("./vendor/autoload.php");

$app = new App();

// Api Ver 1
$app->get("/api/v1", [WelcomeController::class, "hello"]);
$app->get("/api/v1/user", [WelcomeController::class, "user"]);

$app->run();
