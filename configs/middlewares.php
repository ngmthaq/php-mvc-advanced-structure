<?php

use App\Middlewares\Authentication;
use App\Middlewares\HandleCors;
use App\Middlewares\TrimString;

return [
    "global" => [
        HandleCors::class,
        TrimString::class,
    ],
    "alias" => [
        "auth" => Authentication::class,
    ]
];
