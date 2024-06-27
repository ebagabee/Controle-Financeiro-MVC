<?php
require_once '../../controllers/ContaPagarController.php';
require_once '../../controllers/EmpresaController.php';

$empresaController = new EmpresaController();
$contaPagarController = new ContaPagarController();

$empresas = $empresaController->list();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $_POST['valor'];
    $data_pagar = $_POST['data_pagar'];
    $pago = isset($_POST['pago']) ? 1 : 0;
    $id_empresa = $_POST['id_empresa'];

    if ($contaPagarController->create($valor, $data_pagar, $pago, $id_empresa)) {
        header("Location: list.php");
        exit();
    } else {
        echo "<p>Erro ao cadastrar conta a pagar.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Conta</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
</head>

<body>
    <header class="bg-info text-white py-4">
        <div class="container">
            <h1 class="mb-0">Adicionar Conta</h1>
        </div>
    </header>
    <div class="container mt-4">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" href="../../../public">Empresas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="create.php">Adicionar Conta</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="list.php">Listar Contas</a>
            </li>
        </ul>
        <div class="card mt-4">
            <div class="card-body">
                <form method="POST">
                    <div class="form-group">
                        <label for="id_empresa">Selecione a Empresa</label>
                        <select class="form-control select2" id="id_empresa" name="id_empresa">
                            <?php foreach ($empresas as $empresa) : ?>
                                <option value="<?php echo $empresa['id_empresa']; ?>"><?php echo $empresa['nome']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="valor">Valor</label>
                        <input type="text" class="form-control" id="valor" name="valor">
                    </div>
                    <div class="form-group">
                        <label for="data_pagar">Data de Pagamento</label>
                        <input type="date" class="form-control" id="data_pagar" name="data_pagar">
                    </div>
                    <button type="submit" class="btn btn-primary">Adicionar Conta</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</body>

</html>