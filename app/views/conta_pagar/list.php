<?php
require_once '../../controllers/ContaPagarController.php';

$contaPagarController = new ContaPagarController();
$contas = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $filtro_empresa = isset($_GET['filtro_empresa']) ? $_GET['filtro_empresa'] : '';
    $filtro_valor = isset($_GET['filtro_valor']) ? $_GET['filtro_valor'] : null;
    $condicao_valor = isset($_GET['condicao_valor']) ? $_GET['condicao_valor'] : '';
    $filtro_data = isset($_GET['filtro_data']) ? $_GET['filtro_data'] : '';

    $contas = $contaPagarController->list($filtro_empresa, $filtro_valor, $condicao_valor, $filtro_data);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_conta_pagar'])) {
    $id_conta_pagar = $_POST['id_conta_pagar'];
    $success = $contaPagarController->marcarPago($id_conta_pagar);

    if ($success) {
        header("Location: list.php");
        exit();
    } else {
        echo "<p>Erro ao marcar a conta como paga.</p>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_conta'])) {
    $id_conta_pagar = $_POST['excluir_conta'];
    if ($contaPagarController->delete($id_conta_pagar)) {
        header("Location: list.php");
        exit();
    } else {
        echo "<p>Erro ao excluir a conta a pagar.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Contas a Pagar</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../../../resources/styles.css">
</head>

<body>
    <header class="bg-info text-white py-4">
        <div class="container">
            <h1 class="mb-0">Controle Financeiro de Contas a Pagar</h1>
        </div>
    </header>
    <div class="container mt-4">
        <h2 class="mb-3">Filtrar Contas a Pagar</h2>
        <form method="GET">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filtro_empresa">Nome da Empresa:</label>
                        <input type="text" class="form-control" id="filtro_empresa" name="filtro_empresa" value="<?php echo isset($_GET['filtro_empresa']) ? $_GET['filtro_empresa'] : ''; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filtro_valor">Valor:</label>
                        <input type="number" class="form-control" id="filtro_valor" name="filtro_valor" value="<?php echo isset($_GET['filtro_valor']) ? $_GET['filtro_valor'] : ''; ?>">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="condicao_valor">Condição:</label>
                        <select class="form-control" id="condicao_valor" name="condicao_valor">
                            <option value="">Selecionar...</option>
                            <option value="MAIOR" <?php echo isset($_GET['condicao_valor']) && $_GET['condicao_valor'] === 'MAIOR' ? 'selected' : ''; ?>>Maior que</option>
                            <option value="MENOR" <?php echo isset($_GET['condicao_valor']) && $_GET['condicao_valor'] === 'MENOR' ? 'selected' : ''; ?>>Menor que</option>
                            <option value="IGUAL" <?php echo isset($_GET['condicao_valor']) && $_GET['condicao_valor'] === 'IGUAL' ? 'selected' : ''; ?>>Igual a</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="filtro_data">Data de Pagamento:</label>
                        <input type="date" class="form-control" id="filtro_data" name="filtro_data" value="<?php echo isset($_GET['filtro_data']) ? $_GET['filtro_data'] : ''; ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Filtrar</button>
            <a href="list.php" class="btn btn-secondary ml-2">Limpar Filtros</a>
        </form>
    </div>
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="../../../public/index.php">Empresas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="create.php">Adicionar Conta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="list.php">Listar Contas</a>
            </li>
        </ul>
        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">Lista de Contas a Pagar</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Empresa</th>
                                <th scope="col">Valor</th>
                                <th scope="col">Data de Pagamento</th>
                                <th scope="col">Pago</th>
                                <th scope="col">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contas as $conta) : ?>
                                <tr>
                                    <td><?php echo $conta['nome_empresa']; ?></td>
                                    <td>R$ <?php echo number_format($conta['valor'], 2, ',', '.'); ?></td>
                                    <td><?php echo $conta['data_pagar']; ?></td>
                                    <td class="status-pago <?php echo $conta['pago'] ? 'text-success' : 'text-danger'; ?>"><?php echo $conta['pago'] ? 'Sim' : 'Não'; ?></td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Ações">
                                            <a href="edit.php?id=<?php echo $conta['id_conta_pagar']; ?>" class="btn btn-primary btn-sm">Editar</a>

                                            <form method="POST">
                                                <input type="hidden" name="excluir_conta" value="<?php echo $conta['id_conta_pagar']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm ml-2">Excluir</button>
                                            </form>

                                            <?php if (!$conta['pago']) : ?>
                                                <form class="form-marcar-pago">
                                                    <input type="hidden" name="id_conta_pagar" value="<?php echo $conta['id_conta_pagar']; ?>">
                                                    <button type="button" class="btn btn-success btn-sm marcar-pago-btn">Marcar como Pago</button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Função para marcar como pago
            $(document).on('click', '.marcar-pago-btn', function(e) {

                var form = $(this).closest('form');
                var idContaPagar = form.find('input[name="id_conta_pagar"]').val();

                $.ajax({
                    type: 'POST',
                    url: '../../../helpers/marcar_pago.php',
                    data: {
                        id_conta_pagar: idContaPagar
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            form.find('.marcar-pago-btn').hide();
                            location.reload();
                        } else {
                            alert('Falha ao marcar como pago.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao marcar como pago:', error);
                        alert('Erro ao marcar como pago. Verifique o console para mais detalhes.');
                    }
                });
            });
        });

        $(document).ready(function() {
        $('.marcar-pago-btn').click(function() {
        });
    });
    </script>
</body>

</html>