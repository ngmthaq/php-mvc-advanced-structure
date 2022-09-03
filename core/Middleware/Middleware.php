<?php

namespace Core\Middleware;

use Core\Request\Request;
use Core\Response\Response;

abstract class Middleware
{
    protected $req;
    protected $res;

    public function __construct(Request $req, Response $res)
    {
        $this->req = $req;
        $this->res = $res;
    }

    abstract public function handle(): bool;
}
