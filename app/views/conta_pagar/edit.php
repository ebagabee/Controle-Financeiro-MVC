<?php
require_once '../../controllers/ContaPagarController.php';

$contaPagarController = new ContaPagarController();

if (!isset($_GET['id'])) {
    header("Location: list.php");
    exit();
}

$id_conta_pagar = $_GET['id'];
$conta = $contaPagarController->getById($id_conta_pagar);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_conta'])) {
    $dados = [
        'id_conta_pagar' => $id_conta_pagar,
        'valor' => $_POST['valor'],
        'data_pagar' => $_POST['data_pagar'],
    ];

    if ($contaPagarController->update($dados)) {
        header("Location: list.php");
        exit();
    } else {
        echo "<p>Erro ao atualizar a conta a pagar.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta a Pagar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <header class="bg-info text-white py-4">
        <div class="container">
            <h1 class="mb-0">Controle Financeiro de Contas a Pagar</h1>
        </div>
    </header>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Editar Conta a Pagar</h2>
                <form method="POST">
                    <input type="hidden" name="editar_conta" value="1">
                    <input type="hidden" name="id_conta_pagar" value="<?php echo $conta['id_conta_pagar']; ?>">
                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="text" class="form-control" id="valor" name="valor" value="<?php echo $conta['valor']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="data_pagar">Data de Pagamento</label>
                        <input type="date" class="form-control" id="data_pagar" name="data_pagar" value="<?php echo $conta['data_pagar']; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>