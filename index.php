<?php

use Core\App\App;

include_once("./vendor/autoload.php");
include_once("./helper.php");

$app = new App();

$getRoutes = include_once("./router/get.php");
foreach ($getRoutes as $uri => $config) {
    $middlewares = array_key_exists(3, $config) ? $config[3] : [];
    $app->get($uri, [$config[0], $config[1]], $middlewares);
}

$postRoutes = include_once("./router/post.php");
foreach ($postRoutes as $uri => $config) {
    $middlewares = array_key_exists(3, $config) ? $config[3] : [];
    $app->post($uri, [$config[0], $config[1]], $middlewares);
}

$app->run();
