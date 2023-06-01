<?php

namespace Book\Mvc\Model;

use Book\Mvc\DB;

class User extends Model
{
    protected $id;
    protected $email;
    protected $password;

    public static function findEmail($email)
    {
        $table = self::getTable();

        $sql = "SELECT * FROM $table WHERE email = :email";

        return DB::selectOne($sql, ['email' => $email], static::class);
    }
}
