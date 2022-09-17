<?php

namespace Src\Validators;

use Core\Validator\Validator;

class UpdateUserValidator extends Validator
{
    protected function handle(): bool
    {
        $isValidate = true;

        if (!$this->req->params("id")) {
            $this->errors["id"] = "The id field is required";
            if ($isValidate) $isValidate = false;
        }

        if (!$this->req->params("first_name")) {
            $this->errors["first_name"] = "The first_name field is required";
            if ($isValidate) $isValidate = false;
        }

        if (!$this->req->params("last_name")) {
            $this->errors["last_name"] = "The last_name field is required";
            if ($isValidate) $isValidate = false;
        }

        if (!$this->req->params("email")) {
            $this->errors["email"] = "The email field is required";
            if ($isValidate) $isValidate = false;
        }

        if (!$this->req->params("avatar")) {
            $this->errors["avatar"] = "The avatar field is required";
            if ($isValidate) $isValidate = false;
        }

        if (!$this->req->params("password")) {
            $this->errors["password"] = "The password field is required";
            if ($isValidate) $isValidate = false;
        }

        return $isValidate;
    }
}
