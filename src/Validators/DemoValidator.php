<?php

namespace Src\Validators;

use Core\Validator\Validator;

class DemoValidator extends Validator
{
    protected function handle(): bool
    {
        if (!$this->req->query("name")) {
            $this->errors["name"] = "Missing query param `name`";

            return false;
        }

        return true;
    }
}
