<?php

namespace Core\Locale;

use Core\Helpers\Helper;
use Exception;

final class Locale
{
    public function __construct()
    {
        //
    }

    final public function config()
    {
        $configs = require(__ROOT__ . "\\configs\\locale.php");

        if (!array_key_exists("locale", $configs)) {
            throw new Exception("Missing key 'locale' in /configs/locale.php");
        }

        if (!array_key_exists("default_locale", $configs)) {
            throw new Exception("Missing key 'default_locale' in /configs/locale.php");
        }

        if (!array_key_exists("available_locales", $configs)) {
            throw new Exception("Missing key 'available_locales' in /configs/locale.php");
        }

        if (empty(Helper::session(LOCALE_KEY))) {
            $locale = $configs["locale"] ?? $configs["default_locale"] ?? "vi";
            $_SESSION[LOCALE_KEY] = $locale;
        }

        if (empty(Helper::session(DEFAULT_LOCALE_KEY))) {
            $locale = $configs["default_locale"] ?? "vi";
            $_SESSION[DEFAULT_LOCALE_KEY] = $locale;
        }

        if (empty(Helper::session(AVAILABLE_LOCALES_KEY))) {
            $locales = $configs["available_locales"] ?? [];
            $_SESSION[AVAILABLE_LOCALES_KEY] = json_encode($locales);
        }
    }

    final public function get(string $key)
    {
        return Helper::session($key);
    }

    final public function setLocale(string $value)
    {
        $availableLocales = json_decode(Helper::session(AVAILABLE_LOCALES_KEY));
        if (array_key_exists($value, $availableLocales)) {
            $_SESSION[LOCALE_KEY] = $value;
        } else {
            throw new Exception("Invalid locale value '$value'");
        }
    }

    final public function trans(string $format, array $args = [])
    {
        $locale = Helper::session(LOCALE_KEY);
        if (file_exists($dir = __ROOT__ . "\\lang\\" . $locale . ".json")) {
            $json = file_get_contents($dir);
            $contents = (array)json_decode($json);
            if (array_key_exists($format, $contents)) {
                $content = $contents[$format];
                foreach ($args as $key => $arg) {
                    $content = str_replace(":" . $key . ":", $arg, $content);
                }
                echo $content;
            }
        }

        return $format;
    }
}
