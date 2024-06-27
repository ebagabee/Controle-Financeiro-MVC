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

    public function readAll($filtro_empresa = '', $filtro_valor = null, $condicao_valor = '', $filtro_data = '')
    {
        $query = "SELECT cp.*, e.nome AS nome_empresa 
              FROM " . $this->table_name . " cp
              LEFT JOIN tbl_empresa e ON cp.id_empresa = e.id_empresa";

        // Aplicando filtros
        $params = [];
        $where = [];

        if (!empty($filtro_empresa)) {
            $where[] = "e.nome LIKE :filtro_empresa";
            $params['filtro_empresa'] = '%' . $filtro_empresa . '%';
        }

        if ($filtro_valor !== null && !empty($condicao_valor)) {
            switch ($condicao_valor) {
                case 'MAIOR':
                    $where[] = "cp.valor > :filtro_valor";
                    break;
                case 'MENOR':
                    $where[] = "cp.valor < :filtro_valor";
                    break;
                case 'IGUAL':
                    $where[] = "cp.valor = :filtro_valor";
                    break;
                default:
                    break;
            }
            $params['filtro_valor'] = $filtro_valor;
        }

        if (!empty($filtro_data)) {
            $where[] = "cp.data_pagar = :filtro_data";
            $params['filtro_data'] = $filtro_data;
        }

        if (!empty($where)) {
            $query .= " WHERE " . implode(" AND ", $where);
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
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

    public function calcularValorFinal($valor, $data_pagar)
    {
        $hoje = date('Y-m-d');
        $data_pagar = new DateTime($data_pagar);
        $data_pagar_formatada = $data_pagar->format('Y-m-d');

        if ($hoje < $data_pagar_formatada) {
            $valor_final = $valor * 0.95;
        } elseif ($hoje == $data_pagar_formatada) {
            $valor_final = $valor;
        } else {
            $valor_final = $valor * 1.1;
        }

        return $valor_final;
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
