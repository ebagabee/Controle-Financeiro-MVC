<?php
require_once __DIR__ . '/../app/controllers/EmpresaController.php';

$empresaController = new EmpresaController();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $empresaController->create($nome);
    header("Location: index.php");
    exit();
}

if (isset($_POST['excluir_empresa'])) {
    $id_empresa = $_POST['excluir_empresa'];
    $empresaController->delete($id_empresa);
    header("Location: index.php");
    exit();
}

$empresas = $empresaController->list();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Controle Financeiro - Empresas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../resources/styles.css">
</head>
<body>
    <header class="bg-info text-white py-4">
        <div class="container">
            <h1 class="mb-0">Controle Financeiro de Empresas</h1>
        </div>
    </header>
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" href="#">Empresas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../app/views/conta_pagar/create.php">Adicionar Conta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../app/views/conta_pagar/list.php">Listar Contas</a>
            </li>
        </ul>

        <div class="card mt-4">
            <div class="card-body">
                <h2 class="card-title">Criar Nova Empresa</h2>
                <form action="index.php" method="POST" class="mb-4">
                    <div class="form-group">
                        <label for="nome">Nome da Empresa:</label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Criar Empresa</button>
                </form>

                <hr>

                <h2 class="card-title">Lista de Empresas</h2>
                <ul class="list-group">
                    <?php foreach ($empresas as $empresa): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?php echo $empresa['nome']; ?>
                            <form action="index.php" method="POST">
                                <input type="hidden" name="excluir_empresa" value="<?php echo $empresa['id_empresa']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="../resources/js/scripts.js"></script>
</body>
</html>
