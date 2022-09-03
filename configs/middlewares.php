<?php

return [
    "global" => [
        \Src\Middlewares\HandleCors::class,
        \Src\Middlewares\DetectMethod::class,
        \Src\Middlewares\SessionStart::class,
    ],
    "alias" => []
];
