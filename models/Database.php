<?php

define('SQL_HOST', '127.0.0.1');
define('SQL_DBNAME', 'zpravodajstviprojektcz1');
define('SQL_USERNAME', 'zpravodajs1');
define('SQL_PASSWORD', 'f8V22Gy5');
class Database {
   private static $pdo;

    public static function connect()
    {
        $database = 'mysql:dbname=' . SQL_DBNAME . ';host=' . SQL_HOST . '';
        $user = SQL_USERNAME;
        $password = SQL_PASSWORD;
        $settings = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,     //chyby jako podmínky
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",//utf-8
            PDO::ATTR_EMULATE_PREPARES => false
        );
        try {
            self::$pdo = new PDO($database, $user, $password, $settings);
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }


    public static function queryOne($query, $params = array())
    {
        $result = self::$pdo->prepare($query);
        $result->execute($params);
        return $result->fetch();
    }

    public static function queryAll($query, $params = array())
    {
        $result = self::$pdo->prepare($query);
        $result->execute($params);
        return $result->fetchAll();
    }

	public static function query($query, $params = array()) {
		$result = self::$pdo->prepare($query);
		$result->execute($params);
		return $result->rowCount();
	}

	public static function insert($table, $params = array()) {
		return self::query("INSERT INTO $table (".
		implode(', ', array_keys($params)).
		") VALUES (".str_repeat('?,', sizeOf($params)-1)."?)",
			array_values($params));

	}

	public static function update($table, $values = array(), $condition, $params = array()) {
		return self::query("UPDATE $table SET ".
		implode(' = ?, ', array_keys($values)).
		" = ? " . $condition,
		array_merge(array_values($values), $params));
	}
}