<?php

namespace Core\Helpers;

use Exception;

final class Logger
{
    final public static function write(Exception $e, string $name = null)
    {
        $dir = __ROOT__ . "\\resources\\logs\\";
        if (!is_dir($dir)) mkdir($dir);
        $name = $name ? $name : "error";
        $fileName = $name . "_" . gmdate("d_m_Y") . "_UTC.log";
        $file = fopen($dir . $fileName, "a");
        $time = "[" . time() . "]: ";
        $content = $time . $e->getMessage() . " at line " . $e->getLine() . PHP_EOL;
        $content = $content . "File: " . $e->getFile() . PHP_EOL;
        $content = $content . "Trace: " . $e->getTraceAsString() . PHP_EOL . PHP_EOL;
        fwrite($file, $content);
        fclose($file);
    }
}
