<?php

namespace Core\Hash;

use Core\Helpers\Helper;
use Core\Helpers\Str;

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

    final public static function jwt(string $uuid)
    {
        // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        // Create token payload as a JSON string
        $payload = json_encode(['user_id' => $uuid]);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $sign = Helper::env("APP_SIGNATURE") . $uuid . Str::generateRandomString();
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $sign, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }
}
