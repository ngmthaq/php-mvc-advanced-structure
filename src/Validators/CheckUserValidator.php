<?php

namespace Src\Validators;

use Core\Validator\Validator;

class CheckUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->required("id");
        $this->required("password");

        return $this->validated;
    }
}
