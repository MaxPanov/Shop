<?php

class DB {

    private static $pdo;

    private function __construct() {}

    static function instance() {

        if (!self::$pdo) {
            try {
                include __DIR__."/connect/connect.php"; 
                self::$pdo = new PDO("mysql:host=localhost;dbname=".DB_NAME, DB_USERNAME, DB_PASSWORD);

                // echo "Подключение к базе данных установлено...";

            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }


    static function query(string $sql, $params = [], string $className = 'stdClass'): ?array {

        $sth = self::$pdo->prepare($sql);
        $result = $sth->execute($params);

        if ($result === false) return null;

        return $sth->fetchAll(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, $className);

    }
}