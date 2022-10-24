<?php

namespace App\Controllers\V1;

use Core\Controller\Controller;
use Core\Request\Request;
use Core\Response\Response;

class WelcomeController extends Controller
{
    public function __construct(Request $req, Response $res)
    {
        parent::__construct($req, $res);
    }

    /** REST OF CODE **/

    public function index()
    {
        return $this->res->view("pages.index");
    }

    public function demo()
    {
        return $this->res->flash(["success" => "Open index success"])->redirect("/");
    }
}
