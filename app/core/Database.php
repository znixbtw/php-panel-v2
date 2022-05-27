<?php
defined('BASE_PATH') or exit('No direct script access allowed');

class Database
{

    protected mixed $statement;
    private string $dbHost = "localhost";
    private string $dbUser = "root";
    private string $dbPass = "";
    private string $dbName = "php-panel";

    protected function query($sql)
    {
        $this->statement = $this->connect()->query($sql);
    }

    protected function connect()
    {

        try {
            $dsn = 'mysql:host='.$this->dbHost.';dbname='.$this->dbName;
            $pdo = new PDO($dsn, $this->dbUser, $this->dbPass);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return $pdo;
        } catch (PDOException $e) {
            print ("Error!: ".$e->getMessage()."<br/>");
            die();
        }

    }

    protected function prepare($sql)
    {
        $this->statement = $this->connect()->prepare($sql);
    }

}
