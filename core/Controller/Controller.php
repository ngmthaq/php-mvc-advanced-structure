<?php

namespace Core\Controller;

use Core\Request\Request;
use Core\Response\Response;

abstract class Controller
{
    protected $req;
    protected $res;

    public function __construct(Request $req, Response $res)
    {
        $this->req = $req;
        $this->res = $res;
    }
}
