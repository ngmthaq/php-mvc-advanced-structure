<?php

use App\Middlewares\ApiAuthentication;
use App\Middlewares\CsrfProtection;
use App\Middlewares\HandleCors;
use App\Middlewares\TrimString;

return [
    "global" => [
        CsrfProtection::class,
        HandleCors::class,
        TrimString::class,
    ],
    "alias" => [
        "auth" => ApiAuthentication::class,
    ]
];
