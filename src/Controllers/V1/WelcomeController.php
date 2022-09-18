<?php

namespace Src\Controllers\V1;

use Core\Controller\Controller;
use Core\Hash\Hash;
use Core\Request\Request;
use Core\Response\Response;
use Src\Validators\CheckUserValidator;
use Src\Validators\DeleteUserValidator;
use Src\Validators\DemoValidator;
use Src\Validators\InsertUserValidator;
use Src\Validators\UpdateUserValidator;

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

    public function insertUser()
    {
        $validator = new InsertUserValidator($this->req, USE_PARAMS);

        if ($validator->validate()) {
            $data = $this->req->params();
            $data["password"] = Hash::make($data["password"]);
            $isInserted = $this->builder->table("users")->insert($data);
            if ($isInserted) {
                $user = $this->builder->table("users")->where("email", $this->req->params("email"))->first();
                $res = ["message" => "Insert Successfully", "user" => $user];
            } else {
                $res = ["message" => "Insert Failed"];
            }

            return $this->res->json($res);
        }
    }

    public function updateUser()
    {
        $validator = new UpdateUserValidator($this->req, USE_PARAMS);

        if ($validator->validate()) {
            $status = STATUS_SUCCESS;
            $id = $this->req->params("id");
            $data = $this->req->params();
            $data["password"] = Hash::make($data["password"]);
            $isUpdated = $this->builder->table("users")->where("id", $id)->update($data);
            if ($isUpdated) {
                $user = $this->builder->table("users")->where("id", $id)->first();
                $res = ["message" => "Update Successfully", "user" => $user];
            } else {
                $res = ["error" => "Update Failed"];
                $status = STATUS_INTERNAL_SERVER_ERROR;
            }

            return $this->res->json($res, $status);
        }
    }

    public function deleteUser()
    {
        $validator = new DeleteUserValidator($this->req, USE_PARAMS);

        if ($validator->validate()) {
            $status = STATUS_SUCCESS;
            $id = $this->req->params("id");
            $isDeleted = $this->builder->table("users")->where("id", $id)->delete();
            if ($isDeleted) {
                $res = ["message" => "Delete Successfully"];
            } else {
                $res = ["error" => "Delete Failed"];
                $status = STATUS_INTERNAL_SERVER_ERROR;
            }

            return $this->res->json($res, $status);
        }
    }

    public function checkUser()
    {
        $validator = new CheckUserValidator($this->req);

        if ($validator->validate()) {
            $user = $this->builder->table("users")->where("id", $this->req->query("id"))->first();
            $message = Hash::check($this->req->query("password"), $user["password"]) ? "Same" : "Diff";

            return $this->res->json(compact("message"));
        }
    }
}
