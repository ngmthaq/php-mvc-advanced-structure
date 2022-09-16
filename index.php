<?php

use Core\App\App;
use Src\Controllers\V1\WelcomeController;

include_once("./vendor/autoload.php");

$app = new App();

// Get method
$app->get("/api/v1/hello", [WelcomeController::class, "hello"]);
$app->get("/api/v1/users", [WelcomeController::class, "users"]);
$app->get("/api/v1/demo", [WelcomeController::class, "demo"]);

// Post method
$app->post("/api/v1/hello", [WelcomeController::class, "helloPost"]);

$app->run();
