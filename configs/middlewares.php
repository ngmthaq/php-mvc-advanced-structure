<?php

use Src\Middlewares\HandleCors;
use Src\Middlewares\SessionStart;
use Src\Middlewares\TrimString;

return [
    "global" => [
        HandleCors::class,
        SessionStart::class,
        TrimString::class,
    ],
    "alias" => []
];
