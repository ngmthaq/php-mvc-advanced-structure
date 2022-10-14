<?php

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
