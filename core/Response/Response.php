<?php

namespace Core\Response;

use Core\View\View;

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
            echo resources($path, BINARY_RESOURCES);
        } else {
            $this->json(["error" => "File not found"], STATUS_NOT_FOUND);
        }
    }

    final public function view(string $template, array $data = [], array $mergeData = [])
    {
        header('Content-Type: text/html; charset=UTF-8');
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
}
