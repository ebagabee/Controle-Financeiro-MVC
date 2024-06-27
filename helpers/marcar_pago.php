<?php
require_once '../app/controllers/ContaPagarController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_conta_pagar'])) {
    $id_conta_pagar = $_POST['id_conta_pagar'];

    $contaPagarController = new ContaPagarController();
    $success = $contaPagarController->marcarPago($id_conta_pagar);

    echo json_encode(['success' => $success]);
    exit();
}

echo json_encode(['success' => false]);
exit();
