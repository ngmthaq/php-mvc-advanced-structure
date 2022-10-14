<?php

use Src\Middlewares\HandleCors;
use Src\Middlewares\TrimString;

return [
    "global" => [
        HandleCors::class,
        TrimString::class,
    ],
    "alias" => []
];
