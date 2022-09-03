<?php

namespace Core\Request;

class Request
{
    protected $_CONFIGS;

    public function __construct(array $configs)
    {
        $this->_CONFIGS = $configs;
    }

    public function configs()
    {
        return $this->_CONFIGS;
    }

    public function query(string $var = "*"): mixed
    {
        if ($var === "*") return $_GET;
        if (array_key_exists($var, $_GET)) return $_GET[$var];
        return null;
    }

    public function params(string $var = "*"): mixed
    {
        if ($var === "*") return $_POST;
        if (array_key_exists($var, $_POST)) return $_POST[$var];
        return null;
    }

    public function headers(string $var = "*"): mixed
    {
        $_HEADERS = $this->getReqHeaders();
        if ($var === "*") return $_HEADERS;
        if (array_key_exists($var, $_HEADERS)) return $_HEADERS[$var];
        return null;
    }

    private function getReqHeaders(): array
    {
        $headers = array();
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }
}
