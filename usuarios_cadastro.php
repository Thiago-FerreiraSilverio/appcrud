<?php
include 'usuarios_controller.php';
include 'header.php';

session_start();
// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
    }
//Pega todos os usuários para preencher os dados da tabela
$users = getUsers();

//Variável que guarda o ID do usuário que será editado
$userToEdit = null;

// Verifica se existe o parâmetro edit pelo método GET
// e sé há um ID para edição de usuário
if (isset($_GET['edit'])) {
    $userToEdit = getUser($_GET['edit']);
}
?>



<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Usuários</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function clearForm() {
            document.getElementById('nome').value = '';
            document.getElementById('telefone').value = '';
            document.getElementById('email').value = '';
            document.getElementById('senha').value = '';
            document.getElementById('id').value = '';
        }
    </script>
</head>

<body>
    <div class="container mt-5">
        <!-- Centralização do Título -->
        <h2 class="text-center">Cadastro de Usuários</h2>
        <form method="POST" action="" class="row g-3 mt-4">
            <input type="hidden" id="id" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">

            <!-- Campo Nome -->
            <div class="col-md-6">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" 
                    value="<?php echo $userToEdit['nome'] ?? ''; ?>" required>
            </div>

            <!-- Campo Telefone -->
            <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone:</label>
                <input type="text" id="telefone" name="telefone" class="form-control" 
                    value="<?php echo $userToEdit['telefone'] ?? ''; ?>" required>
            </div>

            <!-- Campo Email -->
            <div class="col-md-6">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" 
                    value="<?php echo $userToEdit['email'] ?? ''; ?>" required>
            </div>

            <!-- Campo Senha -->
            <div class="col-md-6">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" id="senha" name="senha" class="form-control" required>
            </div>

            <!-- Botões Centralizados -->
            <div class="col-12 text-center">
                <button type="submit" name="save" class="btn btn-success">Salvar</button>
                <button type="submit" name="update" class="btn btn-secondary">Atualizar</button>
                <button type="button" onclick="clearForm()" class="btn btn-primary">Limpar</button>
            </div>
        </form>

        <!-- Tabela de Usuários -->
        <h2 class="text-center mt-5">Usuários Cadastrados</h2>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['nome']; ?></td>
                        <td><?php echo $user['telefone']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td>
                            <a href="?edit=<?php echo $user['id']; ?>" class="btn btn-sm btn-outline-secondary">Editar</a>
                            <a href="?delete=<?php echo $user['id']; ?>" 
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
