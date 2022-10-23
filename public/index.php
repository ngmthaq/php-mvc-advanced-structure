<?php

session_start();

use Core\App\App;
use Core\Helpers\Helper;

include_once("../vendor/autoload.php");
include_once("../helper.php");

$app = new App();

$getWebRoutes = include_once("../router/web/get.php");
foreach ($getWebRoutes as $uri => $config) {
    $middlewares = array_key_exists(2, $config) ? $config[2] : [];
    $app->get($uri, [$config[0], $config[1]], $middlewares);
}

$postWebRoutes = include_once("../router/web/post.php");
foreach ($postWebRoutes as $uri => $config) {
    $middlewares = array_key_exists(2, $config) ? $config[2] : [];
    $app->post($uri, [$config[0], $config[1]], $middlewares);
}

$getApiRoutes = include_once("../router/api/get.php");
foreach ($getApiRoutes as $uri => $config) {
    $middlewares = array_key_exists(2, $config) ? $config[2] : [];
    $app->get("/api" . $uri, [$config[0], $config[1]], $middlewares, true);
}

$postApiRoutes = include_once("../router/api/post.php");
foreach ($postApiRoutes as $uri => $config) {
    $middlewares = array_key_exists(2, $config) ? $config[2] : [];
    $app->post("/api" . $uri, [$config[0], $config[1]], $middlewares, true);
}

$GLOBALS[__APP__] = $app;

if ((int)Helper::env("APP_MAINTENANCE")) {
    $app->maintenance();
} else {
    $app->run();
}
