<?php

namespace Src\Validators;

use Core\Validator\Validator;

class DemoValidator extends Validator
{
    protected function handle(): bool
    {
        $this->required("name");

        return $this->validated;
    }
}
