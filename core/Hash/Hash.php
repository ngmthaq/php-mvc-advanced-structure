<?php

namespace Core\Hash;

final class Hash
{
    final public static function make(string $str): string
    {
        return hash("sha256", $str);
    }

    final public static function check(string $str, string $hash): bool
    {
        return hash_equals($hash, self::make($str));
    }
}
