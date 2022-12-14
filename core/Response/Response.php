<?php

namespace Core\Response;

use Core\Locale\Locale;
use Core\View\View;
use Exception;

final class Response
{
    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }

    final public function resource(string $path)
    {
        $relativePath = str_replace("/", "\\", __ROOT__ . "\\resources\\" . $path);
        if (file_exists($relativePath)) {
            http_response_code(STATUS_SUCCESS);
            header('Content-Type: ' . mime_content_type($relativePath));
            header("Content-Transfer-Encoding: Binary");
            header("Content-Length:" . filesize($relativePath));
            header("Content-Disposition: attachment;");
            echo resources($path, false, BINARY_RESOURCES);
        } else {
            throw new Exception("Cannot find resource");
        }
    }

    final public function view(string $template, array $data = [], array $mergeData = [], int $status = STATUS_SUCCESS)
    {
        http_response_code($status);
        header('Content-Type: text/html; charset=UTF-8');
        $locale = new Locale();
        $currentLocale = $locale->get(LOCALE_KEY);
        $lang = file_get_contents(__ROOT__ . "\\lang\\" . $currentLocale . ".json");
        $mergeData = array_merge($mergeData, ["_lang" => $lang]);
        $this->view->render($template, $data, $mergeData);
    }

    final public function json(mixed $data, int $status = STATUS_SUCCESS, array $headers = []): void
    {
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(["error" => json_last_error_msg()]);
            if ($json === false) {
                $json = '{"error":"unknown"}';
            }
            http_response_code(STATUS_INTERNAL_SERVER_ERROR);
        } else {
            http_response_code($status);
        }

        foreach ($headers as $header) {
            header($header);
        }

        header('Content-Type: application/json; charset=utf-8');
        echo $json;
    }

    final public function redirect(string $path)
    {
        header('Location: ' . $path);
    }

    final public function flash(array $sessions)
    {
        foreach ($sessions as $key => $value) {
            $_SESSION[FLASH_SESSION_TEMPLATE_KEY . $key] = $value;
        }

        return $this;
    }
}
