<?php

namespace Core\Validator;

use Core\Database\QueryBuilder;
use Exception;

trait Rules
{
    protected QueryBuilder $builder;

    protected function required(string $key): void
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (array_key_exists($key, $data)) {
            if (!$data[$key]) {
                $this->failedValidation($key, "The `$key` field is required");
            }
        } else {
            $this->failedValidation($key, "The `$key` field is required");
        }
    }

    protected function email(string $key): void
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (array_key_exists($key, $data)) {
            if (!filter_var($data[$key], FILTER_VALIDATE_EMAIL)) {
                $this->failedValidation($key, "The `$key` field must be a valid email address");
            }
        }
    }

    protected function number(string $key): void
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (array_key_exists($key, $data)) {
            if (!filter_var($data[$key], FILTER_VALIDATE_INT) || !filter_var($data[$key], FILTER_VALIDATE_FLOAT)) {
                $this->failedValidation($key, "The `$key` field must be a number");
            }
        }
    }

    protected function alphabet(string $key): void
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (array_key_exists($key, $data)) {
            if (!preg_match("/^[\sa-zA-Z\p{L}]*$/gmu", $data[$key])) {
                $this->failedValidation($key, "The `$key` field must only contain letters");
            }
        }
    }

    protected function min(string $key, int|float $min): void
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (!$min) {
            throw new Exception("Missing min value for validation");
        }

        if (array_key_exists($key, $data)) {
            if (gettype($data[$key]) === "string") {
                if (strlen($data[$key]) < $min) {
                    $this->failedValidation($key, "The `$key` field must be at least $min characters");
                }
            }

            if (gettype($data[$key]) === "integer" || gettype($data[$key]) === "double") {
                if ($data[$key] < $min) {
                    $this->failedValidation($key, "The `$key` field must be at least $min");
                }
            }

            if (gettype($data[$key]) === "array") {
                if (count($data[$key]) < $min) {
                    $this->failedValidation($key, "The `$key` field must be at least $min items");
                }
            }
        }
    }

    protected function max(string $key, int|float $max): void
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (!$max) {
            throw new Exception("Missing max value for validation");
        }

        if (array_key_exists($key, $data)) {
            if (gettype($data[$key]) === "string") {
                if (strlen($data[$key]) > $max) {
                    $this->failedValidation($key, "The `$key` field must not be greater than $max characters");
                }
            }

            if (gettype($data[$key]) === "integer" || gettype($data[$key]) === "double") {
                if ($data[$key] > $max) {
                    $this->failedValidation($key, "The `$key` field must not be greater than $max");
                }
            }

            if (gettype($data[$key]) === "array") {
                if (count($data[$key]) > $max) {
                    $this->failedValidation($key, "The `$key` field must not have more than $max items");
                }
            }
        }
    }

    public function unique(string $key, string $table, string $col)
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (!$table) {
            throw new Exception("Missing table name for validation");
        }

        if (!$col) {
            throw new Exception("Missing column name for validation");
        }

        if (array_key_exists($key, $data)) {
            $record = $this->builder->table($table)->where($col, $data[$key])->first();
            if ($record) {
                $this->failedValidation($key, "The `$key` field has already been taken");
            }
        }
    }

    public function exist(string $key, string $table, string $col)
    {
        if ($this->mode === USE_QUERY) {
            $data = $this->req->query();
        } else {
            $data = $this->req->params();
        }

        if (!$key) {
            throw new Exception("Missing key for validation");
        }

        if (!$table) {
            throw new Exception("Missing table name for validation");
        }

        if (!$col) {
            throw new Exception("Missing column name for validation");
        }

        if (array_key_exists($key, $data)) {
            $record = $this->builder->table($table)->where($col, $data[$key])->first();
            if (!$record) {
                $this->failedValidation($key, "The selected `$key` is invalid");
            }
        }
    }
}
