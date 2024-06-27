<?php
require_once __DIR__ . '/../../config/database.php';

class Empresa {
    private $conn;
    private $table_name = 'tbl_empresa';

    public $id_empresa;
    public $nome;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function readAll() {
        $query = "SELECT id_empresa, nome FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nome) VALUES (:nome)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nome', $this->nome);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_empresa = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id_empresa);
        return $stmt->execute();
    }
}
?>
