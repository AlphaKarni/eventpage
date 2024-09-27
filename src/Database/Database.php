<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private $db_host = '127.0.0.1';
    private $db_name = 'Event';
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

    public function select(string $query, array $params = [])
    {
        $stmt = $this->dbConnection()->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function executeDML(string $sql, array $params = []){
        $stmt = $this->dbConnection()->prepare($sql);
        return $stmt->execute($params);
    }

}