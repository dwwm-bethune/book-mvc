<?php

namespace Book\Mvc;

class DB
{
    protected const HOST = 'localhost';
    protected const NAME = 'book-mvc';
    protected const USER = 'root';
    protected const PASSWORD = '';
    protected static $db;

    protected static function db()
    {
        if (!self::$db) {
            self::$db = new \PDO('mysql:host='.DB::HOST.';port=3306;dbname='.DB::NAME, DB::USER, DB::PASSWORD, [
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }

        return self::$db;
    }

    public static function select($sql, $bindings = [], $class = null)
    {
        $query = self::db()->prepare($sql);
        $query->execute($bindings);

        return $query->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public static function selectOne($sql, $bindings = [], $class = null)
    {
        $query = self::db()->prepare($sql);
        $query->execute($bindings);
        $query->setFetchMode(\PDO::FETCH_CLASS, $class);

        return $query->fetch();
    }

    public static function insert($sql, $bindings = [])
    {
        return self::db()->prepare($sql)->execute($bindings);
    }

    public static function update($sql, $bindings = [])
    {
        return self::db()->prepare($sql)->execute($bindings);
    }

    public static function delete($sql, $bindings = [])
    {
        return self::db()->prepare($sql)->execute($bindings);
    }
}
