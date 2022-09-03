<?php

return [
    "global" => [
        \Src\Middlewares\HandleCors::class,
        \Src\Middlewares\DetectMethod::class,
        \Src\Middlewares\SessionStart::class,
        \Src\Middlewares\TrimString::class,
    ],
    "alias" => []
];
