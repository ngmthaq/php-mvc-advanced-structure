<?php

namespace Src\Validators;

use Core\Validator\Validator;

class DeleteUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->require("id");

        return $this->validated;
    }
}
