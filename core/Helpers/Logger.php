<?php

namespace Core\Helpers;

use Exception;

final class Logger
{
    final public static function write(Exception $e)
    {
        $dir = __ROOT__ . "\\logs\\";
        $fileName = gmdate("d_m_Y") . "_UTC.log";
        $file = fopen($dir . $fileName, "a");
        $time = "[" . time() . "]: ";
        $content = $time . $e->getMessage() . " at line " . $e->getLine() . PHP_EOL;
        $content = $content . "File: " . $e->getFile() . PHP_EOL;
        $content = $content . "Trace: " . $e->getTraceAsString() . PHP_EOL . PHP_EOL;
        fwrite($file, $content);
        fclose($file);
    }
}