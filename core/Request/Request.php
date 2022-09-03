<?php

namespace Core\Request;

class Request
{
    protected $_CONFIGS;
    protected $_ORIGIN_GET;
    protected $_ORIGIN_POST;

    public function __construct(array $configs)
    {
        $this->_CONFIGS = $configs;
        $this->_ORIGIN_GET = $_GET;
        $this->_ORIGIN_POST = $_POST;
    }

    public function mutateQuery(array $data)
    {
        $this->_ORIGIN_GET = $data;
    }

    public function mutateParams(array $data)
    {
        $this->_ORIGIN_POST = $data;
    }

    public function configs()
    {
        return $this->_CONFIGS;
    }

    public function query(string $var = "*"): mixed
    {
        if ($var === "*") return $this->_ORIGIN_GET;
        if (array_key_exists($var, $this->_ORIGIN_GET)) return $this->_ORIGIN_GET[$var];
        return null;
    }

    public function params(string $var = "*"): mixed
    {
        if ($var === "*") return $this->_ORIGIN_POST;
        if (array_key_exists($var, $this->_ORIGIN_POST)) return $this->_ORIGIN_POST[$var];
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
