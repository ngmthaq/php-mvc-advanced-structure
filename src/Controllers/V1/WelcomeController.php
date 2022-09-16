<?php

namespace Src\Controllers\V1;

use Core\Controller\Controller;
use Core\Request\Request;
use Core\Response\Response;
use Src\Validators\DemoValidator;

class WelcomeController extends Controller
{
    public function __construct(Request $req, Response $res)
    {
        parent::__construct($req, $res);
    }

    public function hello()
    {
        $validator = new DemoValidator($this->req);
        if ($validator->validate()) {
            return $this->res->json(["hello" => $this->req->query("name")]);
        }
    }

    public function helloPost()
    {
        return $this->res->json(["hello" => "world in post method"]);
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
