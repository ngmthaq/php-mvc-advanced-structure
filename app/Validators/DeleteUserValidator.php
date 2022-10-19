<?php

namespace App\Validators;

use Core\Validator\Validator;

class DeleteUserValidator extends Validator
{
    protected function handle(): bool
    {
        $this->required("id");

        return $this->validated;
    }
}
