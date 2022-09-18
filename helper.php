<?php

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
