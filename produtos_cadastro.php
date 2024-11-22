<?php
include 'produtos_controller.php';
include 'header.php';

session_start();
// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Pega todos os produtos para preencher os dados da tabela
$products = getProducts();

// Variável que guarda o ID do produto que será editado
$productToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
if (isset($_GET['edit'])) {
    $productToEdit = getProduct($_GET['edit']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function clearForm() {
            document.getElementById('form-produto').reset();
            document.getElementById('id').value = '';
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <!-- Centralização do Título -->
        <h2 class="text-center">Cadastro de Produtos</h2>
        <form id="form-produto" method="POST" action="" enctype="multipart/form-data" class="row g-3 mt-4">
            <input type="hidden" id="id" name="id" value="<?php echo $productToEdit['id'] ?? ''; ?>">

            <!-- Campo Nome -->
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" 
                    value="<?php echo $productToEdit['nome'] ?? ''; ?>" required>
            </div>

            <!-- Campo Descrição -->
            <div class="col-md-6">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" required><?php echo $productToEdit['descricao'] ?? ''; ?></textarea>
            </div>

            <!-- Campo Marca -->
            <div class="col-md-6">
                <label for="marca" class="form-label">Marca:</label>
                <input type="text" id="marca" name="marca" class="form-control" 
                    value="<?php echo $productToEdit['marca'] ?? ''; ?>" required>
            </div>

            <!-- Campo Modelo -->
            <div class="col-md-6">
                <label for="modelo" class="form-label">Modelo:</label>
                <input type="text" id="modelo" name="modelo" class="form-control" 
                    value="<?php echo $productToEdit['modelo'] ?? ''; ?>" required>
            </div>

            <!-- Campo Valor Unitário -->
            <div class="col-md-6">
                <label for="valorunitario" class="form-label">Valor Unitário:</label>
                <input type="number" step="0.01" id="valorunitario" name="valorunitario" class="form-control" 
                    value="<?php echo $productToEdit['valorunitario'] ?? ''; ?>" required>
            </div>

            <!-- Campo Categoria -->
            <div class="col-md-6">
                <label for="categoria" class="form-label">Categoria:</label>
                <input type="text" id="categoria" name="categoria" class="form-control" 
                    value="<?php echo $productToEdit['categoria'] ?? ''; ?>" required>
            </div>

            <!-- Campo Imagem -->
            <div class="col-md-6">
                <label for="url_img" class="form-label">Imagem:</label>
                <input type="file" id="url_img" name="url_img" class="form-control">
            </div>

            <!-- Campo Ativo -->
            <div class="col-md-6">
                <label for="ativo" class="form-label">Ativo:</label>
                <input type="checkbox" id="ativo" name="ativo" class="form-check-input" 
                    <?php echo isset($productToEdit['ativo']) && $productToEdit['ativo'] ? 'checked' : ''; ?>>
            </div>

            <!-- Botões Centralizados -->
            <div class="col-12 text-center">
                <button type="submit" name="save" class="btn btn-success">Salvar</button>
                <button type="submit" name="update" class="btn btn-secondary">Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-primary">Limpar</button>
            </div>
        </form>

        <!-- Tabela de Produtos -->
        <h2 class="text-center mt-5">Produtos Cadastrados</h2>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Valor Unitário</th>
                    <th>Categoria</th>
                    <th>Imagem</th>
                    <th>Ativo</th>
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
                        <td><?php echo $product['valorunitario']; ?></td>
                        <td><?php echo $product['categoria']; ?></td>
                        <td>
                            <img src="<?php echo $product['url_img']; ?>" alt="Imagem do Produto" style="width: 100px;">
                        </td>
                        <td><?php echo $product['ativo'] ? 'Sim' : 'Não'; ?></td>
                        <td>
                            <a href="?edit=<?php echo $product['id']; ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <a href="?delete=<?php echo $product['id']; ?>" 
                                class="btn btn-sm btn-outline-danger"
                                onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php include 'footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
