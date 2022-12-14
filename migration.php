<?php

require_once("./core/Database/Migration.php");

/********** DATABASE MIGRATION EXECUTE **********/
execute(function () {
    createTable("authentications", [
        "id" => "varchar(50) PRIMARY KEY",
        "user_id" => "varchar(50) NOT NULL",
        "access_token" => "text NOT NULL",
        "refresh_token" => "varchar(64) NOT NULL",
        "created_at" => "timestamp DEFAULT CURRENT_TIMESTAMP",
        "access_token_expired_at" => "timestamp NOT NULL",
        "refresh_token_expired_at" => "timestamp NOT NULL",
        "updated_at" => "timestamp",
    ]);

    createTable("users", [
        "id" => "varchar(50) PRIMARY KEY",
        "name" => "nvarchar(255) NOT NULL",
        "email" => "nvarchar(255) NOT NULL",
        "address" => "nvarchar(255)",
        "password" => "nvarchar(255) NOT NULL",
        "status" => "int NOT NULL DEFAULT 0", // 0: active, 1: inactive, 2: banned
        "remember_token" => "nvarchar(255)",
        "created_at" => "timestamp DEFAULT CURRENT_TIMESTAMP",
        "update_at" => "timestamp",
    ]);
}, true);
