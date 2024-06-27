<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../../config/database.php';

class EmpresaController {
    private $empresa;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->empresa = new Empresa($db);
    }

    public function list() {
        return $this->empresa->readAll();
    }

    public function create($nome) {
        $this->empresa->nome = $nome;
        return $this->empresa->create();
    }

    public function delete($id_empresa) {
        $this->empresa->id_empresa = $id_empresa;
        return $this->empresa->delete();
    }
}
?>
