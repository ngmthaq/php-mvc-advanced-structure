<?php

namespace App\Validators;

use Core\Validator\Validator;

class UpdateUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->required("id");
        $this->required("first_name");
        $this->required("last_name");
        $this->required("email");
        $this->required("avatar");
        $this->required("password");

        $this->exist("id", "users", "id");
        $this->unique("email", "users", "email");

        return $this->validated;
    }
}
