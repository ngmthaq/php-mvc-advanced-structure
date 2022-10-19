<?php

namespace App\Validators;

use Core\Validator\Validator;

class LoginValidator extends Validator
{
    protected function handle(): bool
    {
        $this->required("email");
        $this->required("password");

        return $this->validated;
    }
}
