<?php

namespace Core\Helpers;

final class Str
{
    public static function generateRandomString($length = 10)
    {
        $time = time();
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz" . $time;
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

        for ($i = 0; $i < 5; $i++) {
            if ($i === 0 || $i === 4) {
                array_push($result, self::generateRandomString(8));
            } else {
                array_push($result, self::generateRandomString(4));
            }
        }

        return implode("-", $result);
    }
}
