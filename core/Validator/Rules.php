<?php

namespace Core\Validator;

trait Rules
{
    protected $message;

    final protected function validator(array $rules): bool
    {
        $isValidated = true;

        if (!$isValidated) {
            $this->handleErrorResponse();
        }

        return $isValidated;
    }

    protected function handleErrorResponse()
    {
        return $this->res->json([
            "error" => "Failed Validation",
            "details" => $this->message,
        ], STATUS_FAILED_VALIDATION);
    }

    final protected function required($value): bool
    {
        if ($value === "" || $value === null) return false;

        return true;
    }

    final protected function email($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    final protected function url($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_URL) ? true : false;
    }

    final protected function int($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_INT) ? true : false;
    }

    final protected function float($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_FLOAT) ? true : false;
    }

    final protected function characters($value): bool
    {
        return preg_match("/[^a-zA-Z_\x{00C0}-\x{00FF}\x{1EA0}-\x{1EFF}]/u", $value) ? true : false;
    }

    final protected function json($value): bool
    {
        if (!empty($value)) {
            return is_string($value) &&
                is_array(json_decode($value, true)) ? true : false;
        }

        return false;
    }

    final protected function array($value): bool
    {
        return is_array($value);
    }

    final protected function min($value, int|float $num): bool
    {
        if (!$this->int($value) || !$this->float($value)) return false;
        if ($value < $num) return false;
        return true;
    }

    final protected function max($value, int|float $num): bool
    {
        if (!$this->int($value) || !$this->float($value)) return false;
        if ($value > $num) return false;
        return true;
    }

    final protected function equal($value, int|float $num): bool
    {
        if (!$this->int($value) || !$this->float($value)) return false;
        if ($value === $num) return false;
        return true;
    }

    final protected function minLength($value, int|float $num): bool
    {
        if (!$this->characters($value)) return false;
        if (strlen($value) < $num) return false;
        return true;
    }

    final protected function maxLength($value, int|float $num): bool
    {
        if (!$this->characters($value)) return false;
        if (strlen($value) > $num) return false;
        return true;
    }
}
