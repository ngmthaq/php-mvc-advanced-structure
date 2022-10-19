<?php

namespace App\Middlewares;

use Core\Middleware\Middleware;

class TrimString extends Middleware
{
    public function handle(): bool
    {
        $trimmedQueries = array_map(function ($q) {
            if (gettype($q) === "string") {
                return trim($q);
            }

            return $q;
        }, $_GET);

        $trimmedParams = array_map(function ($p) {
            if (gettype($p) === "string") {
                return trim($p);
            }

            return $p;
        }, $_POST);

        $this->req->mutateQuery($trimmedQueries);
        $this->req->mutateParams($trimmedParams);

        return true;
    }
}
