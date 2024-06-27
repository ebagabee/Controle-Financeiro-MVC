<?php
require_once '../app/controllers/ContaPagarController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_conta_pagar'])) {
    $id_conta_pagar = $_POST['id_conta_pagar'];

    $contaPagarController = new ContaPagarController();

    // Marca a conta como paga
    $success = $contaPagarController->marcarPago($id_conta_pagar);

    if ($success) {
        // Obtém os detalhes da conta para calcular o valor final
        $conta = $contaPagarController->getById($id_conta_pagar);

        if ($conta) {
            // Calcula o valor final com base na data de pagamento
            $valor_final = calcularValorFinal($conta['valor'], $conta['data_pagar']);

            // Atualiza a conta com o valor final
            $contaPagarController->update([
                'id_conta_pagar' => $id_conta_pagar,
                'valor' => $valor_final,
                'data_pagar' => $conta['data_pagar']
            ]);

            echo json_encode(['success' => true]);
            exit();
        } else {
            echo json_encode(['success' => false, 'error' => 'Erro ao obter detalhes da conta após marcação como paga.']);
            exit();
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Erro ao marcar a conta como paga.']);
        exit();
    }
}

echo json_encode(['success' => false, 'error' => 'Requisição inválida.']);
exit();

// Função para calcular o valor final com desconto
function calcularValorFinal($valor, $data_pagar)
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
