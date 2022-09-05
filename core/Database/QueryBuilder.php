<?php

namespace Core\Database;

use Exception;
use PDOStatement;
use Src\Helpers\Helper;

final class QueryBuilder
{
    use Connection;

    const JOIN_TYPES = ["INNER", "LEFT", "RIGHT", "inner", "left", "right"];

    protected $table = "";
    protected $columns = ["*"];
    protected $conditions = [];
    protected $bindings = [];
    protected $combinations = [];
    protected $limit = null;
    protected $offset = null;
    protected $orderBy = null;
    protected $orderDir = "ASC";

    final public function __construct()
    {
        $this->connect();
    }

    final public function raw(string $sql): PDOStatement
    {
        return $this->conn->query($sql);
    }

    final public function table(string $table): QueryBuilder
    {
        $this->table = $table;
        return $this;
    }

    final public function limit(int $num): QueryBuilder
    {
        $this->limit = $num;
        return $this;
    }

    final public function offset(int $num): QueryBuilder
    {
        $this->offset = $num;
        return $this;
    }

    final public function where(string $column, string $value, string $operator = "="): QueryBuilder
    {
        $query = "WHERE $column $operator :$column";
        array_push($this->conditions, $query);
        $this->bindings = array_merge($this->bindings, [$column => $value]);
        return $this;
    }

    final public function andWhere(string $column, string $value, string $operator = "="): QueryBuilder
    {
        $query = "AND $column $operator :$column";
        array_push($this->conditions, $query);
        $this->bindings = array_merge($this->bindings, [$column => $value]);
        return $this;
    }

    final public function orWhere(string $column, string $value, string $operator = "="): QueryBuilder
    {
        $query = "OR $column $operator :$column";
        array_push($this->conditions, $query);
        $this->bindings = array_merge($this->bindings, [$column => $value]);
        return $this;
    }

    final public function innerJoin(string $relatedTable, string $relatedColumn, string $table = "", string $column = "id"): QueryBuilder
    {
        $table = $table === "" ? $this->table : $table;
        if ($table === "") {
            throw new Exception("Current table name not found");
        }

        $query = "INNER JOIN $relatedTable ON $table.$column = $relatedTable.$relatedColumn";
        array_push($this->combinations, $query);
        return $this;
    }

    final public function leftJoin(string $relatedTable, string $relatedColumn, string $table = "", string $column = "id"): QueryBuilder
    {
        $table = $table === "" ? $this->table : $table;
        if ($table === "") {
            throw new Exception("Current table name not found");
        }

        $query = "LEFT JOIN $relatedTable ON $table.$column = $relatedTable.$relatedColumn";
        array_push($this->combinations, $query);
        return $this;
    }

    final public function rightJoin(string $relatedTable, string $relatedColumn, string $table = "", string $column = "id"): QueryBuilder
    {
        $table = $table === "" ? $this->table : $table;
        if ($table === "") {
            throw new Exception("Current table name not found");
        }

        $query = "RIGHT JOIN $relatedTable ON $table.$column = $relatedTable.$relatedColumn";
        array_push($this->combinations, $query);
        return $this;
    }

    final public function order(string $col, string $dir = "ASC"): QueryBuilder
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
        return $stm->fetchAll();
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
        return $stm->fetch();
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
}
