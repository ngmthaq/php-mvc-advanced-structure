<?php

namespace Core\Model;

use Core\Database\Connection;
use Core\Helpers\Pluralizer;
use Exception;
use ReflectionClass;

abstract class Model
{
    use Connection;

    protected string $table;
    protected string $primaryKey;
    protected array $attributes;
    protected array $hidden;
    protected array $guards;

    private $conditions = [];
    private $bindings = [];
    private $combinations = [];
    private $limit = null;
    private $offset = null;
    private $orderBy = null;
    private $orderDir = "ASC";

    public function __construct()
    {
        $this->attributes = [];
        $this->primaryKey = "id";
        $this->hidden = [];
        $this->guards = [];

        $class = new ReflectionClass($this);
        $this->table = strtolower(Pluralizer::pluralize($class->getShortName()));

        $this->connect();
    }

    private function unsetHiddenFields(array $records): array
    {
        $result = array_map(function ($r) {
            foreach ($this->hidden as $h) {
                unset($r[$h]);
            }

            $model = $this;
            $model->attributes = $r;

            return $model;
        }, $records);

        return $result;
    }

    private function unsetHiddenField(array $record): Model
    {
        foreach ($this->hidden as $h) {
            unset($record[$h]);
        }

        $model = $this;
        $model->attributes = $record;

        return $model;
    }

    private function unsetGuards(array $data)
    {
        foreach ($this->guards as $g) {
            unset($data[$g]);
        }

        return $data;
    }

    final public function all(): array
    {
        $sql = "SELECT * FROM " . $this->table;
        $stm = $this->conn->prepare($sql);
        $stm->execute();
        $records = $stm->fetchAll();

        return $this->unsetHiddenFields($records);
    }

    final public function find($id): Model
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id = $id";
        $stm = $this->conn->prepare($sql);
        $stm->execute();
        $record = $stm->fetch();

        return $this->unsetHiddenField($record);
    }

    final public function limit(int $num): Model
    {
        $this->limit = $num;

        return $this;
    }

    final public function offset(int $num): Model
    {
        $this->offset = $num;

        return $this;
    }

    final public function where(string $column, string $value, string $operator = "="): Model
    {
        $query = "WHERE $column $operator :$column";
        array_push($this->conditions, $query);
        $this->bindings = array_merge($this->bindings, [$column => $value]);

        return $this;
    }

    final public function andWhere(string $column, string $value, string $operator = "="): Model
    {
        $query = "AND $column $operator :$column";
        array_push($this->conditions, $query);
        $this->bindings = array_merge($this->bindings, [$column => $value]);

        return $this;
    }

    final public function orWhere(string $column, string $value, string $operator = "="): Model
    {
        $query = "OR $column $operator :$column";
        array_push($this->conditions, $query);
        $this->bindings = array_merge($this->bindings, [$column => $value]);

        return $this;
    }

    final public function innerJoin(string $relatedTable, string $relatedColumn, string $table = "", string $column = "id"): Model
    {
        $table = $table === "" ? $this->table : $table;
        if ($table === "") {
            throw new Exception("Current table name not found");
        }

        $query = "INNER JOIN $relatedTable ON $table.$column = $relatedTable.$relatedColumn";
        array_push($this->combinations, $query);

        return $this;
    }

    final public function leftJoin(string $relatedTable, string $relatedColumn, string $table = "", string $column = "id"): Model
    {
        $table = $table === "" ? $this->table : $table;
        if ($table === "") {
            throw new Exception("Current table name not found");
        }

        $query = "LEFT JOIN $relatedTable ON $table.$column = $relatedTable.$relatedColumn";
        array_push($this->combinations, $query);

        return $this;
    }

    final public function rightJoin(string $relatedTable, string $relatedColumn, string $table = "", string $column = "id"): Model
    {
        $table = $table === "" ? $this->table : $table;
        if ($table === "") {
            throw new Exception("Current table name not found");
        }

        $query = "RIGHT JOIN $relatedTable ON $table.$column = $relatedTable.$relatedColumn";
        array_push($this->combinations, $query);

        return $this;
    }

    final public function order(string $col, string $dir = "ASC"): Model
    {
        $this->orderBy = $col;
        $this->orderDir = $dir;

        return $this;
    }

    final public function get(array $columns = ["*"])
    {
        $cols = implode(", ", $columns);
        $conditionQuery = implode(" ", $this->conditions);
        $combinationQuery = implode(" ", $this->combinations);
        $table = $this->table;
        $limit = $this->limit;
        $offset = $this->offset;
        $orderBy = $this->orderBy;
        $orderDir = $this->orderDir;
        $query = "SELECT $cols FROM $table $combinationQuery $conditionQuery";

        if (!$table) {
            throw new Exception("Can't find the table name to execute the query");
        }

        if ($orderBy) {
            $query = $query . " ORDER BY $orderBy $orderDir";
        }

        if ($limit) {
            $query = $query . " LIMIT $limit";
        }

        if ($offset) {
            $query = $query . " OFFSET $offset";
        }

        $stm = $this->conn->prepare($query);
        $stm->execute($this->bindings);
        $this->clear();

        $records = $stm->fetchAll();

        return $this->unsetHiddenFields($records);
    }

    final public function first(array $columns = ["*"])
    {
        $cols = implode(", ", $columns);
        $conditionQuery = implode(" ", $this->conditions);
        $combinationQuery = implode(" ", $this->combinations);
        $table = $this->table;
        $offset = $this->offset;
        $orderBy = $this->orderBy;
        $orderDir = $this->orderDir;
        $query = "SELECT $cols FROM $table $combinationQuery $conditionQuery";

        if (!$table) {
            throw new Exception("Can't find the table name to execute the query");
        }

        if ($orderBy) {
            $query = $query . " ORDER BY $orderBy $orderDir";
        }

        $query = $query . " LIMIT 1";

        if ($offset) {
            $query = $query . " OFFSET $offset";
        }

        $stm = $this->conn->prepare($query);
        $stm->execute($this->bindings);
        $this->clear();

        $record = $stm->fetch();

        return $this->unsetHiddenField($record);
    }

    final public function clear()
    {
        $this->table = "";
        $this->columns = ["*"];
        $this->conditions = [];
        $this->bindings = [];
        $this->combinations = [];
        $this->limit = null;
        $this->offset = null;
        $this->orderBy = null;
        $this->orderDir = "ASC";
    }

    final public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    final public function commit()
    {
        $this->conn->commit();
    }

    final public function rollback()
    {
        $this->conn->rollback();
    }

    final public function insert(array $data): bool
    {
        try {
            $data = $this->unsetGuards($data);
            $table = $this->table;

            if (!$table) {
                throw new Exception("Can't find the table name to execute insert query");
            }

            $columns = implode(", ", array_keys($data));
            $values = implode(", ", array_map(function ($v) {
                return ":$v";
            }, array_keys($data)));

            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $stm = $this->conn->prepare($sql);
            $this->clear();

            return $stm->execute($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    final public function update(array $data): bool
    {
        try {
            $data = $this->unsetGuards($data);
            $table = $this->table;

            if (!$table) {
                throw new Exception("Can't find the table name to execute update query");
            }

            $conditionQuery = implode(" ", $this->conditions);
            $conditionBinding = $this->bindings;

            $binding = implode(", ", array_map(function ($k) {
                return "$k = :$k";
            }, array_keys($data)));

            $sql = "UPDATE $table SET $binding $conditionQuery";
            $stm = $this->conn->prepare($sql);
            $this->clear();

            return $stm->execute(array_merge($data, $conditionBinding));
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    final public function delete(): bool
    {
        try {
            $table = $this->table;

            if (!$table) {
                throw new Exception("Can't find the table name to execute delete query");
            }

            $conditionQuery = implode(" ", $this->conditions);
            $conditionBinding = $this->bindings;
            $sql = "DELETE FROM $table $conditionQuery";
            $stm = $this->conn->prepare($sql);
            $this->clear();

            return $stm->execute($conditionBinding);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    final public function attr(string $key = "*")
    {
        if ($key === "*") return $this->attributes;
        if (array_key_exists($key, $this->attributes)) return $this->attributes[$key];
        return null;
    }
}
