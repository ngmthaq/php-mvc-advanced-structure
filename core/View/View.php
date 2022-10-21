<?php

namespace Core\View;

use Core\Protection\Csrf;
use Exception;
use Jenssegers\Blade\Blade;

final class View
{
    private $blade;
    private $csrf;

    public function __construct()
    {
        $this->csrf = new Csrf();
        $this->blade = new Blade(__ROOT__ . "\\app\\Views", __ROOT__ . "\\resources\\views");
        $this->directive();
    }

    private function directive()
    {
        $this->blade->directive("csrf", function () {
            return $this->csrf->csrfInputTag();
        });

        $this->blade->directive("meta", function () {
            return $this->csrf->csrfMetaTag();
        });
    }

    final protected function config(string $template, array $data = [], array $mergeData = [])
    {
        $file = __ROOT__ . "\\app\\Views\\" . str_replace(".", "\\", $template) . ".blade.php";
        if (file_exists($file)) {
            return $this->blade->render(str_replace(".", "\\", $template), $data, $mergeData);
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
