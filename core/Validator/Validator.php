<?php

namespace Core\Validator;

use Core\Database\QueryBuilder;
use Core\Request\Request;
use Core\Response\Response;

abstract class Validator
{
    use Rules;

    protected Request $req;
    protected Response $res;
    protected array $errors;
    protected bool $validated;
    protected int $mode;

    public function __construct(Request $request, int $mode = USE_QUERY)
    {
        $this->req = $request;
        $this->res = new Response();
        $this->builder = new QueryBuilder();
        $this->validated = true;
        $this->mode = $mode;
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

    protected function failedValidation(string $errorKey, string $errorMessage): void
    {
        $this->errors[$errorKey][] = $errorMessage;
        if ($this->validated) $this->validated = false;
    }
}
