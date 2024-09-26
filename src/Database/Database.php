<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private $db_host = '127.0.0.1';
    private $db_name = 'event';
    private $db_username = 'root';
    private $db_password = 'nexus123';
    public function dbConnection()
    {
        try
        {
            $conn = new PDO('mysql:host='.$this->db_host.'; port=3336; dbname='.$this->db_name,$this->db_username,$this->db_password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        catch(PDOException $e)
        {
            echo "Connection error ".$e->getMessage();
            exit;
        }
    }

    public function select(string $sql, array $params = [])
    {
        $stmt = $this->dbConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function executeDML(string $sql, array $params = []){
        $stmt = $this->dbConnection()->prepare($sql);
        return $stmt->execute($params);
    }

}

//$database = new Database();
//$pdo = $database->dbConnection();
//
//$sql = "SELECT username FROM event.Users";
//$stmt = $pdo->prepare($sql);
//$stmt->execute();
//print_r($stmt->fetchAll());