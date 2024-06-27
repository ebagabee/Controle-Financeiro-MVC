<?php
class Database {
    private $host = ''; // localhost por exemplo 
    private $db_name = ''; // nome do banco de dados criado  Ex: controle_financeiro
    private $username = ''; // nome do user do banco de dados Ex: root
    private $password = ''; // senha do banco de dados Ex: 123456
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
