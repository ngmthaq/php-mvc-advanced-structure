<?php

namespace Core\Protection;

use Core\Hash\Hash;
use Core\Helpers\Helper;
use Core\Helpers\Str;

final class Csrf
{
    final public function generate()
    {
        $str = Str::generateRandomString(64);
        $token = Hash::make($str);

        setcookie(CSRF_TOKEN_KEY, $token);
    }

    final public function csrfMetaTag()
    {
        return "<meta name=\"csrf-token\" content=\"<?php echo csrf() ?>\">";
    }

    final public function csrfInputTag()
    {
        return "<input type=\"hidden\" id=\"_token\" name=\"_token\" value=\"<?php echo csrf() ?>\">";
    }

    final public function validate(string $csrfToken)
    {
        $token = Helper::cookie(CSRF_TOKEN_KEY);

        return $token && $token === $csrfToken;
    }
}
