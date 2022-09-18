<?php

namespace Src\Validators;

use Core\Validator\Validator;

class UpdateUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->require("id");
        $this->require("first_name");
        $this->require("last_name");
        $this->require("email");
        $this->require("avatar");
        $this->require("password");

        $this->exist("id", "users", "id");
        $this->unique("email", "users", "email");

        return $this->validated;
    }
}
