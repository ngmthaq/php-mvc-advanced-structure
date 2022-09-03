<?php

use Src\Middlewares\DetectMethod;
use Src\Middlewares\HandleCors;
use Src\Middlewares\SessionStart;
use Src\Middlewares\TrimString;

return [
    "global" => [
        HandleCors::class,
        DetectMethod::class,
        SessionStart::class,
        TrimString::class,
    ],
    "alias" => []
];
