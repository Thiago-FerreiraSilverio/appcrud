<?php
include 'produtos_controller.php';
include 'header.php';

// Pega todos os produtos para preencher os dados da tabela
$products = getProducts();
$productToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
if (isset($_GET['edit'])) {
    $productToEdit = getProduct($_GET['edit']);
}

session_start();

// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        td {
            text-align: center;
        }

        .active-product {
            background-color: green;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
        }

        .inactive-product {
            background-color: red;
            color: #fff;
            padding: 5px;
            border-radius: 5px;
        }

        .table td,
        .table th {
            padding: .75rem;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .acoes {
            display: flex;
            justify-content: center;
            gap: 5px;
        }
    </style>
    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('marca').value = '';
            document.getElementById('modelo').value = '';
            document.getElementById('descricao').value = '';
            document.getElementById('id').value = '';
            document.getElementById('valor-unitario').value = '';
            document.getElementById('categoria').value = '';
            document.getElementById('url-imagem').value = '';
            document.getElementById('ativo').checked = false;
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <h2>Cadastro de Produtos</h2>
        <form method="POST" action="" class="form-collumn">

            <input type="hidden" id="id" name="id" value="<?php echo $productToEdit['id'] ?? ''; ?>">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control"
                    value="<?php echo $productToEdit['nome'] ?? ''; ?>" required>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="marca" class="form-label">Marca:</label>
                    <input type="text" id="marca" name="marca" class="form-control"
                        value="<?php echo $productToEdit['marca'] ?? ''; ?>" required>
                </div>
                <div class="col">
                    <label for="modelo" class="form-label">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" class="form-control"
                        value="<?php echo $productToEdit['modelo'] ?? ''; ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control"
                    required><?php echo $productToEdit['descricao'] ?? ''; ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="valor-unitario" class="form-label">Valor Unitário R$:</label>
                    <input type="text" id="valor-unitario" name="valorunitario" class="form-control"
                        value="<?php echo $productToEdit['valorunitario'] ?? ''; ?>" required>
                </div>
                <div class="col">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <input type="text" id="categoria" name="categoria" class="form-control"
                        value="<?php echo $productToEdit['categoria'] ?? ''; ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="url-imagem" class="form-label">URL da Imagem:</label>
                    <input type="text" id="url-imagem" name="url_img" class="form-control"
                        value="<?php echo $productToEdit['url_img'] ?? ''; ?>" required>
                </div>
                <input class="form-check-input me-2" type="checkbox" id="ativo" name="ativo" value="1"
                    <?php echo isset($productToEdit) && $productToEdit['ativo'] ? 'checked' : ''; ?>>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success" name="save">Cadastrar</button>
                <button type="submit" class="btn btn-secondary" name="update">Salvar Alteração</button>
                <button type="button" class="btn btn-primary" onclick="clearForm()">Limpar</button>
            </div>
        </form>

        <h2 class="mt-5">Produtos Cadastrados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Preço</th>
                    <th>Ativo</th>
                    <th>Categoria</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['id']; ?></td>
                        <td><?php echo $product['nome']; ?></td>
                        <td><?php echo $product['descricao']; ?></td>
                        <td><?php echo $product['marca']; ?></td>
                        <td><?php echo $product['modelo']; ?></td>
                        <td>R$ <?php echo number_format($product['valorunitario'], 2, ',', '.'); ?></td>
                        <td>
                            <span class="<?php echo $product['ativo'] ? 'active-product' : 'inactive-product'; ?>">
                                <?php echo $product['ativo'] ? 'Ativo' : 'Inativo'; ?>
                            </span>
                        </td>
                        <td><?php echo $product['categoria']; ?></td>
                        <td>
                            <img src="<?php echo $product['url_img']; ?>" alt="Imagem do Produto" class="img-fluid" style="max-width: 100px; height: auto;">
                        </td>
                        <td class="acoes">
                            <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-outline-secondary">Editar</a>
                            <a href="?delete=<?php echo $product['id']; ?>" class="btn btn-outline-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include 'footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
