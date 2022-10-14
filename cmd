<?php

$cmd = array_key_exists(1, $argv) ? $argv[1] : null;

if ($cmd) {
    if ($cmd === "refresh") {
        generateKey();
        echo "Clear server data successfully";
    }
}

function generateKey()
{
    $regex = "/^((APP_KEY=)[a-z0-9]+)|(APP_KEY=)/m";
    $key = md5(date(DATE_RFC2822)) . rand(0, 255);
    $env = file_get_contents(".env");
    $env = preg_replace($regex, "APP_KEY=$key", $env);
    $file = fopen(".env", "w+") or die("Unable to open .env file");
    fwrite($file, $env);
    fclose($file);
    echo "Generated key: $key" . PHP_EOL;
}
