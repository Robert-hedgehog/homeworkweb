<?php

class Database
{
    protected static $pdo;

    protected static function getPdo()
    {
        if (empty(static::$pdo)) {
            static::$pdo = new PDO('mysql:host=host.docker.internal;dbname=calendar', 'root', 'root');
        
            static::$pdo->exec('SET NAMES "utf8";'); 
        }
        return static::$pdo;    
    }

    public static function prepare($sql)
    {
        return static::getPdo()->prepare($sql);
    }

    public static function query($sqlQuery, array $params = []) {
        if (!empty($params)) {
            $sql = static::prepare($sqlQuery);
            $sql->execute($params);
            return $sql;
        }
        return static::getPdo()->query($sqlQuery);
    }

    public static function exec($sqlQuery, array $params = [])
    {
        if (!empty($params)) {
            $sql = static::prepare($sqlQuery);
            $sql->execute($params);
            return $sql->rowCount();
        }
        return static::getPdo()->exec($sqlQuery);
    }
}
?>