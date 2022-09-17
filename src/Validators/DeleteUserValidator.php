<?php

namespace Src\Validators;

use Core\Validator\Validator;

class DeleteUserValidator extends Validator
{
    protected function handle(): bool
    {
        $isValidate = true;

        if (!$this->req->params("id")) {
            $this->errors["id"] = "The id field is required";
            if ($isValidate) $isValidate = false;
        }

        return $isValidate;
    }
}
