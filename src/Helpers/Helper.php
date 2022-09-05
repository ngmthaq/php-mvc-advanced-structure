<?php

namespace Src\Helpers;

use Core\Helpers\Helper as CoreHelper;

class Helper extends CoreHelper
{
    public static function env(string $var = "*")
    {
        if ($var === "*") return $_ENV;
        if (array_key_exists($var, $_ENV)) return $_ENV[$var];
        return null;
    }

    public static function server(string $var = "*")
    {
        if ($var === "*") return $_SERVER;
        if (array_key_exists($var, $_SERVER)) return $_SERVER[$var];
        return null;
    }

    public static function session(string $var = "*")
    {
        if ($var === "*") return $_SESSION;
        if (array_key_exists($var, $_SESSION)) return $_SESSION[$var];
        return null;
    }

    public static function dump()
    {
        $arguments = func_get_args();
        echo "<pre>";
        foreach ($arguments as $arg) {
            print_r($arg);
            echo "<br>";
            echo "--------------------";
            echo "<br>";
        }
        echo "</pre>";
        die();
    }

    public static function generateRandomString($length = 10)
    {
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
        $charactersLength = strlen($characters);
        $randomString = "";
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public static function randomId()
    {
        $result = [];
        for ($i = 0; $i < 4; $i++) {
            if ($i === 0) {
                array_push($result, self::generateRandomString(8));
            } else {
                array_push($result, self::generateRandomString(4));
            }
        }

        array_push($result, date("Ymd"));

        return implode("-", $result);
    }
}
