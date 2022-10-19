<?php

namespace Core\View;

use Exception;
use Jenssegers\Blade\Blade;

final class View
{
    final protected function config(string $template, array $data = [], array $mergeData = [])
    {
        $blade = new Blade(__ROOT__ . "\\app\\Views", __ROOT__ . "\\resources\\views");
        $file = __ROOT__ . "\\app\\Views\\" . str_replace(".", "\\", $template) . ".blade.php";
        if (file_exists($file)) {
            return $blade->render(str_replace(".", "\\", $template), $data, $mergeData);
        } else {
            throw new Exception("View not found");
        }
    }

    final public function render(string $template, array $data = [], array $mergeData = [])
    {
        echo $this->config($template, $data, $mergeData);
    }

    final public function getContent(string $template, array $data = [], array $mergeData = [])
    {
        return $this->config($template, $data, $mergeData);
    }
}
