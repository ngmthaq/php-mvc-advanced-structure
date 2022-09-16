<?php

namespace Core\Validator;

use Core\Request\Request;
use Core\Response\Response;

abstract class Validator
{
    protected $req;
    protected $res;
    protected $errors;

    public function __construct(Request $request)
    {
        $this->req = $request;
        $this->res = new Response();
        $this->mutateParams();
        $this->mutateQuery();
    }

    public function validate(): bool
    {
        if (!$this->handle()) {
            $this->handleErrorResponse();

            return false;
        }

        return true;
    }

    abstract protected function handle(): bool;

    protected function handleErrorResponse()
    {
        return $this->res->json([
            "error" => "Failed Validation",
            "details" => $this->errors,
        ], STATUS_FAILED_VALIDATION);
    }

    protected function mutateParams()
    {
        $this->req->mutateParams($this->req->params());
    }

    protected function mutateQuery()
    {
        $this->req->mutateQuery($this->req->query());
    }
}
