<?php

namespace Core\Controller;

use Core\Auth\Auth;
use Core\Database\QueryBuilder;
use Core\Request\Request;
use Core\Response\Response;

abstract class Controller
{
    protected $req;
    protected $res;
    protected $builder;
    protected $auth;

    public function __construct(Request $req, Response $res)
    {
        $this->req = $req;
        $this->res = $res;

        $this->builder = new QueryBuilder();
        $this->auth = new Auth($req);
    }
}
