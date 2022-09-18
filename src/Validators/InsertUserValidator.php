<?php

namespace Src\Validators;

use Core\Validator\Validator;

class InsertUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->require("first_name");
        $this->require("last_name");
        $this->require("email");
        $this->require("avatar");
        $this->require("password");

        $this->email("email");
        $this->unique("email", "users", "email");

        $this->min("password", 6);
        $this->max("password", 12);

        return $this->validated;
    }
}
