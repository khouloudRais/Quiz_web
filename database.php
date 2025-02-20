<?php

class Database {
    private $host = "localhost";  
    private $dbname = "quiz";     
    private $username = "root";   
    private $password = "";       
    private $conn;

    
    public function connect() {
        try {
            
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->username, $this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            
            echo "Erreur de connexion : " . $e->getMessage();
        }
        return $this->conn;
    }

    
    public function disconnect() {
        $this->conn = null;
    }
}

?>
