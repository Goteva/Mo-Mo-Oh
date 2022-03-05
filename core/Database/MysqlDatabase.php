<?php

namespace Core\Database;

use \PDO;

class MysqlDatabase extends Database
{

    private $dbName;
    private $dbUser;
    private $dbPassword;
    private $dbHost;

    private $pdo;

    public function __construct($dbName, $dbUser = 'root', $dbPassword = '', $dbHost = 'localhost')
    {
        $this->dbName = $dbName;
        $this->dbUser = $dbUser;
        $this->dbPassword = $dbPassword;
        $this->dbHost = $dbHost;
    }

    private function getPDO()
    {
        if ($this->pdo === null) {
            $pdo = new PDO('mysql:dbname='.$this->dbName.';host='.$this->dbHost, $this->dbUser, $this->dbPassword);
            $pdo->exec("set names utf8");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo = $pdo;
        }
        return $this->pdo;
    }

    public function query($statement, $className = null, $list = true)
    {
        $pdoStatement = $this->getPDO()->query($statement);

        if(strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0){
            return $pdoStatement;
        }

        if($className === null){
            $pdoStatement->setFetchMode(PDO::FETCH_OBJ);
        }else{
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($list) {
            $datas = $pdoStatement->fetchAll();
        } else {
            $datas = $pdoStatement->fetch();
        }

        return $datas;
    }

    public function prepare($statement, $attributes, $className = null, $list = true, $debug = false)
    {
        $pdoStatement = $this->getPDO()->prepare($statement);
   
        if($debug){
            echo '<pre>'; print_r($pdoStatement->debugDumpParams()); echo '<pre>';
        }

        $results = $pdoStatement->execute($attributes);

        if(strpos($statement, 'UPDATE') === 0 || strpos($statement, 'INSERT') === 0 || strpos($statement, 'DELETE') === 0){
            return $results;
        }

        if($className === null){
            $pdoStatement->setFetchMode(PDO::FETCH_OBJ);
        }else{
            $pdoStatement->setFetchMode(PDO::FETCH_CLASS, $className);
        }

        if ($list) {
            $datas = $pdoStatement->fetchAll();
        } else {
            $datas = $pdoStatement->fetch();
        }

        return $datas;
    }

    public function getLastInsertId()
    {
        return $this->getPDO()->lastInsertId();
    }
}
