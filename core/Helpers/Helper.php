<?php

namespace Core\Helpers;

class Helper
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
}
