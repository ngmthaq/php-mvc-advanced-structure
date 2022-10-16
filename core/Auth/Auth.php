<?php

namespace Core\Auth;

use Core\Database\QueryBuilder;
use Core\Hash\Hash;
use Core\Helpers\Str;
use Core\Request\Request;
use Exception;

final class Auth
{
    private $builder;
    private $configs;
    private $req;

    public function __construct(Request $req)
    {
        $this->builder = new QueryBuilder();
        $this->configs = require(__ROOT__ . "\\configs\\auth.php");
        $this->req = $req;
    }

    final public function login(string $name, string $password, bool $remember = false): bool
    {
        $table = $this->configs["table"];
        $usr = $this->configs["usr"];
        $pw = $this->configs["pw"];

        $record = $this->builder->table($table)->where($usr, $name)->first();
        if ($record) {
            if (Hash::check($password, $record[$pw])) {
                if ($remember) {
                    $rememberToken = Str::generateRandomString(50);
                    $updated = $this->builder->table($table)->update(array_merge($record, ["remember_token" => $rememberToken]));
                    if ($updated) {
                        setcookie(AUTH_KEY, $record["id"], time() + $this->configs["refresh_token_exist_time"]);
                        setcookie(AUTH_REMEMBER_TOKEN, $rememberToken, time() + $this->configs["refresh_token_exist_time"]);
                        unset($_SESSION[AUTH_KEY]);
                    } else {
                        throw new Exception("Cannot set remember token");
                    }
                } else {
                    $_SESSION[AUTH_KEY] = $record["id"];
                    setcookie(AUTH_KEY, "", time() - 3600);
                    setcookie(AUTH_REMEMBER_TOKEN, "", time() - 3600);
                    unset($_COOKIE[AUTH_KEY]);
                    unset($_COOKIE[AUTH_REMEMBER_TOKEN]);
                }

                return true;
            }
        }

        return false;
    }

    final public function logout()
    {
        setcookie(AUTH_KEY, "", time() - 3600);
        setcookie(AUTH_REMEMBER_TOKEN, "", time() - 3600);
        unset($_SESSION[AUTH_KEY]);
        unset($_COOKIE[AUTH_KEY]);
        unset($_COOKIE[AUTH_REMEMBER_TOKEN]);
    }

    final public function loginApi(string $name, string $password)
    {
        $table = $this->configs["table"];
        $usr = $this->configs["usr"];
        $pw = $this->configs["pw"];

        $record = $this->builder->table($table)->where($usr, $name)->first();
        if ($record) {
            if (Hash::check($password, $record[$pw])) {
                $data = $this->getToken($record["id"]);
                $data = array_merge($data, ["id" => Str::randomId(), "user_id" => $record["id"]]);
                $inserted = $this->builder->table("authentications")->insert($data);
                if ($inserted) {
                    unset($data["id"]);

                    return $data;
                } else {
                    throw new Exception("Cannot create access token");
                }
            }
        }

        return null;
    }

    final public function logoutApi()
    {
        $headers = $this->req->getReqHeaders();
        $fullToken = array_key_exists("Authorization", $headers) ? $headers["Authorization"] : "";
        $token = str_replace("Bearer ", "", $fullToken);
        $token = str_replace("bearer ", "", $token);
        $token = trim($token);

        return $this->builder->table("authentications")->where("access_token", $token)->delete();
    }

    final public function getToken(string $uuid)
    {
        if ($uuid) {
            $accessToken = Hash::jwt($uuid);
            $refreshToken = Str::generateRandomString(64);
            $accessTokenExpiredAt = time() + $this->configs["access_token_exist_time"];
            $refreshTokenExpiredAt = time() + $this->configs["refresh_token_exist_time"];

            return [
                "access_token" => $accessToken,
                "refresh_token" => $refreshToken,
                "access_token_expired_at" => mysqlTimestamp($accessTokenExpiredAt),
                "refresh_token_expired_at" => mysqlTimestamp($refreshTokenExpiredAt),
            ];
        }

        throw new Exception("Cannot get token from authenticate");
    }
}
