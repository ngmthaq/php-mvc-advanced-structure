<?php

namespace Core\Auth;

use Core\Hash\Hash;
use Core\Helpers\Helper;
use Core\Helpers\Str;
use Exception;

final class Auth
{
    final public function login(string $usr, string $pw, bool $remember = false)
    {
        //
    }

    final public function logout()
    {
        unset($_SESSION[AUTH_KEY]);
        unset($_COOKIE[AUTH_KEY]);
        setcookie(AUTH_KEY, null, time() - 3600);
    }

    final public function loginApi()
    {
        //
    }

    final public function logoutApi()
    {
        //
    }

    final public function getToken(string $uuid)
    {
        if ($uuid) {
            $accessToken = Hash::jwt($uuid);
            $refreshToken = Str::generateRandomString(64);

            return compact("accessToken", "refreshToken");
        }

        throw new Exception("Cannot get token from authenticate");
    }
}
