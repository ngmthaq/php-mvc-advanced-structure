<?php

namespace Core\Middleware;

use Core\Database\QueryBuilder;
use Core\Request\Request;
use Core\Response\Response;

abstract class Middleware
{
    protected $req;
    protected $res;
    protected $builder;

    public function __construct(Request $req, Response $res)
    {
        $this->req = $req;
        $this->res = $res;
        $this->builder = new QueryBuilder();
    }

    abstract public function handle(): bool;
}
