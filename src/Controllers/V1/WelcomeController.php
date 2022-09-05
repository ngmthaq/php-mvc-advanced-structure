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

    public function users()
    {
        $users = $this->builder->table("users")
            ->where("active", 1)
            ->andWhere("role", 1)
            ->limit(10)
            ->offset(0)
            ->get();

        return $this->res->json(["users" => $users]);
    }

    public function demo()
    {
        $demo = $this->builder->table("demo")->get();

        return $this->res->json(compact("demo"));
    }
}
