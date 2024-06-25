<?php
/* Crearea clasei PDO a bazei de date cu metoda
de conectare la BD utilizând PHP OOP CRUD */
class Database{
    /* Parametrii pentru conectarea la baza de date. Serverul MySQL
    by default folosește username-ul 'root' fără parolă */
    private $host = "localhost";
    private $db_name = "autosalon_api";
    private $username = "root";
    private $password = "";
    public $conn;
  
    // Obținem conecțiunea la BD
    public function getConnection(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>