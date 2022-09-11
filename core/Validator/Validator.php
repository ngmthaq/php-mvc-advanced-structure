<?php

namespace Core\Validator;

use Core\Request\Request;
use Core\Response\Response;

abstract class Validator
{
    protected $req;
    protected $res;

    public function __construct(Request $request)
    {
        $this->req = $request;
        $this->res = new Response();
        $this->mutateParams();
        $this->mutateQuery();
    }

    abstract public function handle(): bool;

    protected function mutateParams()
    {
        $this->req->mutateParams($this->req->params());
    }

    protected function mutateQuery()
    {
        $this->req->mutateQuery($this->req->query());
    }
}
