<?php

use Core\Helpers\Helper;
use Core\Locale\Locale;

function dd()
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

function assets(string $path)
{
    echo "/public/" . $path;
}

function resources(string $path, int $type = BASE64_RESOURCES)
{
    $path = str_replace("/", "\\", __ROOT__ . "\\resources\\" . $path);
    if (file_exists($path)) {
        $data = file_get_contents($path);

        if ($type === BASE64_RESOURCES) {
            $b64 = base64_encode($data);
            $src = 'data:' . mime_content_type($path) . ';base64,' . $b64;

            return $src;
        }

        return $data;
    }

    return null;
}

function changeLocale(string $data)
{
    $locale = new Locale();
    $locale->setLocale($data);
    reload();
}

function trans(string $format, array $args = [])
{
    $locale = new Locale();
    $locale->trans($format, $args);
}

function reload()
{
    header("Refresh:0");
}

function mysqlTimestamp($datetime = "now")
{
    if ($datetime === "now") {
        return date('Y-m-d H:i:s');
    } else {
        return date('Y-m-d H:i:s', $datetime);
    }
}

function isLogin()
{
    return Helper::cookie(AUTH_KEY) || Helper::session(AUTH_KEY) ? true : false;
}

function locale()
{
    $locale = new Locale();
    return $locale->get(LOCALE_KEY);
}

function csrf()
{
    return Helper::session(CSRF_TOKEN_KEY);
}

function isApi()
{
    $app = $GLOBALS[__APP__];
    $method = Helper::server("REQUEST_METHOD");
    $uri = Helper::server("REQUEST_URI");
    $config = $app->getRoute($method, $uri);

    if (!$config) return false;

    return array_key_exists("isApi", $config) ? (bool)$config["isApi"] : false;
}
