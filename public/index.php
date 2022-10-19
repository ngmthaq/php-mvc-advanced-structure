<?php

session_start();

use Core\App\App;
use Core\Helpers\Helper;

include_once("../vendor/autoload.php");
include_once("../helper.php");

$app = new App();

$getRoutes = include_once("../router/get.php");
foreach ($getRoutes as $uri => $config) {
    $middlewares = array_key_exists(2, $config) ? $config[2] : [];
    $app->get($uri, [$config[0], $config[1]], $middlewares);
}

$postRoutes = include_once("../router/post.php");
foreach ($postRoutes as $uri => $config) {
    $middlewares = array_key_exists(2, $config) ? $config[2] : [];
    $app->post($uri, [$config[0], $config[1]], $middlewares);
}

if ((int)Helper::env("APP_MAINTENANCE")) {
    $app->maintenance();
} else {
    $app->run();
}
