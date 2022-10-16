<?php

namespace Src\Middlewares;

use Core\Middleware\Middleware;

class Authentication extends Middleware
{
    public function handle(): bool
    {
        $headers = $this->req->getReqHeaders();
        $fullToken = array_key_exists("Authorization", $headers) ? $headers["Authorization"] : "";
        $token = str_replace("Bearer ", "", $fullToken);
        $token = str_replace("bearer ", "", $token);
        $token = trim($token);

        if ($token) {
            $auth = $this->builder
                ->table("authentications")
                ->where("access_token", $token)
                ->order("created_at", "DESC")
                ->first();

            if ($auth && $auth["access_token_expired_at"] > mysqlTimestamp()) {
                return true;
            }
        }

        $this->res->json(["error" => "Unauthorized"], STATUS_UNAUTHORIZED);

        return false;
    }
}
