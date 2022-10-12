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

    final public function view(string $view, array $data = []): void
    {
        $this->view->render($view, $data);
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
