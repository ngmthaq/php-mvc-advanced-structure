<?php

namespace Core\View;

final class View
{
    final public function render(string $__viewName, array $__vars = [])
    {
        foreach ($__vars as $__key => $__var) {
            $$__key = $__var;
        }

        $__path = __ROOT__ . "\\src\\Views\\" . str_replace(".", "\\", $__viewName) . ".php";

        if (file_exists($__path)) {
            include($__path);
        } else {
            echo "<h1>500 - Server Interner Error</h1>";
            echo "<p>View " . $__viewName . " not found</p>";
        }
    }
}
