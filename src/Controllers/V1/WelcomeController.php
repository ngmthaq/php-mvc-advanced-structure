<?php

namespace Src\Controllers\V1;

use Core\Controller\Controller;
use Core\Request\Request;
use Core\Response\Response;

class WelcomeController extends Controller
{
    public function __construct(Request $req, Response $res)
    {
        parent::__construct($req, $res);
    }

    public function hello()
    {
        return $this->res->json(["hello" => "world"]);
    }

    public function user()
    {
        return $this->res->json(["user" => $this->req->query()]);
    }
}
