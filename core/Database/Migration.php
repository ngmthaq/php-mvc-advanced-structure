<?php

/********** DATABASE MIGRATION CONFIGS **********/
$__env = file_get_contents(".env");
$__conection = preg_match("/(DB_CONNECTION=)[\w\d.\:\\\_]*/m", $__env, $__conectionMatches);
$__host = preg_match("/(DB_HOST=)[\w\d.\:\\\_]*/m", $__env, $__hostMatches);
$__port = preg_match("/(DB_PORT=)[\w\d.\:\\\_]*/m", $__env, $__portMatches);
$__username = preg_match("/(DB_USERNAME=)[\w\d.\:\\\_]*/m", $__env, $__usernameMatches);
$__password = preg_match("/(DB_PASSWORD=)[\w\d.\:\\\_]*/m", $__env, $__passwordMatches);
$__name = preg_match("/(DB_NAME=)[\w\d.\:\\\_]*/m", $__env, $__nameMatches);

$__c = explode("=", $__conectionMatches[0])[1];
$__h = explode("=", $__hostMatches[0])[1];
$__p = explode("=", $__portMatches[0])[1];
$__u = explode("=", $__usernameMatches[0])[1];
$__pw = explode("=", $__passwordMatches[0])[1];
$__n = explode("=", $__nameMatches[0])[1];

$__conf = "$__c:host=$__h;port=$__p;dbname=$__n";
$__conn = new PDO($__conf, $__u, $__pw);
$__conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function createTable(string $name, array $configs)
{
    try {
        global $__conn;
        $sqlTemplate = "CREATE TABLE IF NOT EXISTS $name (%s)";
        $sqlColumns = [];

        foreach ($configs as $col => $conf) {
            $sqlColumns[] = "$col $conf";
        }

        $sql = sprintf($sqlTemplate, implode(", ", $sqlColumns));

        $__conn->exec($sql);

        echo "\033[32mCreate table $name successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function deleteTable(string $name)
{
    try {
        global $__conn;
        $sql = "DROP TABLE IF EXISTS $name";

        $__conn->exec($sql);

        echo "\033[32mDelete table $name successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function truncateTable(string $name)
{
    try {
        global $__conn;
        $sql = "TRUNCATE TABLE $name";

        $__conn->exec($sql);

        echo "\033[32mTruncate table $name successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function addColumn(string $tableName, string $colName, string $colConfig)
{
    try {
        global $__conn;
        $sql = "ALTER TABLE $tableName ADD $colName $colConfig";

        $__conn->exec($sql);

        echo "\033[32mAdd column $colName into table $tableName successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function deleteColumn(string $tableName, string $colName, string $colConfig)
{
    try {
        global $__conn;
        $sql = "ALTER TABLE $tableName DROP $colName $colConfig";

        $__conn->exec($sql);

        echo "\033[32mDelete column $colName from $tableName successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function modifyColumn(string $tableName, string $colName, string $colConfig)
{
    try {
        global $__conn;
        $sql = "ALTER TABLE $tableName MODIFY $colName $colConfig";

        $__conn->exec($sql);

        echo "\033[32mModify column $colName in $tableName successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function refreshDatabase()
{
    try {
        global $__conn, $__n;
        $__conn->exec("DROP DATABASE $__n");
        $__conn->exec("CREATE DATABASE $__n");
        $__conn->exec("USE $__n");
        echo "\033[32mRefresh database successfully  \033[0m" . PHP_EOL;
    } catch (\Throwable $th) {
        throw $th;
    }
}

function execute(callable $callback, bool $forceReloadDb = false)
{
    try {
        if ($forceReloadDb) refreshDatabase();
        $callback();
    } catch (\Throwable $th) {
        echo "\033[31mERR: " . $th->getMessage() . "\033[0m" . PHP_EOL;
    }
}
