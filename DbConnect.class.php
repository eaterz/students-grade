<?php

class DbConnect{

    public $dbconn;
    private $config;

    function __construct()
    {
        $this->config = require "config.php";
        $this->dbconn = new PDO ('mysql:'.http_build_query($this->config,"",";"));
        $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->dbconn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }

    function __destruct()
    {
        $this->dbconn = null;
    }

    function execute($sql, $params = []){
        $query = $this->dbconn->prepare($sql);
        $query->execute($params);
        return $query->fetchAll();
    }
    function query($sql, $params = []) {
        $stmt = $this->dbconn->prepare($sql);

        if (!$stmt) {
            throw new PDOException("Query preparation failed: " . implode(" ", $this->dbconn->errorInfo()));
        }

        $stmt->execute($params);
        return $stmt;
    }
}
 
