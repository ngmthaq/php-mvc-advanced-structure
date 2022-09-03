<?php

namespace Core\Response;

final class Response
{
    final public function json(mixed $data, int $status = STATUS_SUCCESS, array $headers = []): void
    {
        $json = json_encode($data);
        if ($json === false) {
            $json = json_encode(["error" => json_last_error_msg()]);
            if ($json === false) {
                $json = '{"error":"unknown"}';
            }
            http_response_code(STATUS_SERVER_INTERNAL_ERROR);
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
