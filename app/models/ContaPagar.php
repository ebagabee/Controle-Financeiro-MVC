<?php
require_once __DIR__ . '/../../config/database.php';

class ContaPagar
{
    private $conn;
    private $table_name = 'tbl_conta_pagar';

    public $id_conta_pagar;
    public $valor;
    public $data_pagar;
    public $pago;
    public $id_empresa;
    public $nome_empresa;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " (valor, data_pagar, pago, id_empresa) VALUES (:valor, :data_pagar, :pago, :id_empresa)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':valor', $this->valor);
        $stmt->bindParam(':data_pagar', $this->data_pagar);
        $stmt->bindParam(':pago', $this->pago);
        $stmt->bindParam(':id_empresa', $this->id_empresa);
        return $stmt->execute();
    }

    public function readAll()
    {
        $query = "SELECT cp.*, e.nome AS nome_empresa 
                  FROM " . $this->table_name . " cp
                  LEFT JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id_conta_pagar)
    {
        $query = "SELECT cp.*, e.nome AS nome_empresa 
                  FROM " . $this->table_name . " cp
                  LEFT JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa
                  WHERE id_conta_pagar = :id_conta_pagar";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_conta_pagar', $id_conta_pagar);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id_conta_pagar, $valor, $data_pagar)
    {
        $query = "UPDATE " . $this->table_name . " SET valor = :valor, data_pagar = :data_pagar WHERE id_conta_pagar = :id_conta_pagar";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':data_pagar', $data_pagar);
        $stmt->bindParam(':id_conta_pagar', $id_conta_pagar);

        return $stmt->execute();
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id_conta_pagar = :id_conta_pagar";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_conta_pagar', $this->id_conta_pagar);
        return $stmt->execute();
    }

    public function marcarPago($id_conta_pagar)
    {
        $query = "UPDATE " . $this->table_name . " SET pago = 1 WHERE id_conta_pagar = :id_conta_pagar";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_conta_pagar', $id_conta_pagar);
        return $stmt->execute();
    }

    public function marcarPendente($id_conta_pagar)
    {
        $query = "UPDATE " . $this->table_name . " SET pago = 0 WHERE id_conta_pagar = :id_conta_pagar";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_conta_pagar', $id_conta_pagar);
        return $stmt->execute();
    }
}
