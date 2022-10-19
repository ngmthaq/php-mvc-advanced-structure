<?php

namespace App\Models;

use Core\Model\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->hidden = ["password", "remember_token", "reset_password_token"];
    }
}
