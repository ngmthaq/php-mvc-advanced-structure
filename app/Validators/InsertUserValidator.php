<?php

namespace App\Validators;

use Core\Validator\Validator;

class InsertUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->required("first_name");
        $this->required("last_name");
        $this->required("email");
        $this->required("avatar");
        $this->required("password");

        $this->email("email");
        $this->unique("email", "users", "email");

        $this->min("password", 6);
        $this->max("password", 12);

        return $this->validated;
    }
}
