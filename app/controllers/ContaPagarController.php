<?php
require_once __DIR__ . '/../models/ContaPagar.php';
require_once __DIR__ . '/../../config/database.php';

class ContaPagarController
{
    private $contaPagar;
    private $table_name = 'tbl_conta_pagar';

    public function __construct()
    {
        $database = new Database();
        $db = $database->getConnection();
        $this->contaPagar = new ContaPagar($db);
    }

    public function list($filtro_empresa = '', $filtro_valor = null, $condicao_valor = '', $filtro_data = '')
    {
        return $this->contaPagar->readAll($filtro_empresa, $filtro_valor, $condicao_valor, $filtro_data);
    }

    public function create($valor, $data_pagar, $pago, $id_empresa)
    {
        $this->contaPagar->valor = $valor;
        $this->contaPagar->data_pagar = $data_pagar;
        $this->contaPagar->pago = $pago;
        $this->contaPagar->id_empresa = $id_empresa;

        if ($this->contaPagar->create()) {
            return true;
        }
        return false;
    }

    public function getById($id_conta_pagar)
    {
        return $this->contaPagar->getById($id_conta_pagar);
    }

    // public function list()
    // {
    //     return $this->contaPagar->readAll();
    // }

    public function update($dados)
    {
        $id_conta_pagar = $dados['id_conta_pagar'];
        $valor = $dados['valor'];
        $data_pagar = $dados['data_pagar'];

        return $this->contaPagar->update($id_conta_pagar, $valor, $data_pagar);
    }

    public function delete($id_conta_pagar)
    {
        $this->contaPagar->id_conta_pagar = $id_conta_pagar;
        return $this->contaPagar->delete();
    }

    public function marcarPago($id_conta_pagar)
    {
        return $this->contaPagar->marcarPago($id_conta_pagar);
    }

    public function marcarPendente($id_conta_pagar)
    {
        return $this->contaPagar->marcarPendente($id_conta_pagar);
    }
}
