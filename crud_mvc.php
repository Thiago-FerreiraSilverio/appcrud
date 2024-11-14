//===============================================================
//db.php
//===============================================================
<?php
$servername = "localhost"; // ou o endereço do seu servidor
$username = "root"; // padrão do XAMPP
$password = ""; // senha em branco
$dbname = "sistema"; // substitua pelo nome do seu banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
//===============================================================
//footer.php
//===============================================================
<footer class="bg-dark text-white d-flex align-items-center" style="height: 1cm;">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo date("Y"); ?> Seu Nome ou Empresa. Todos os direitos reservados.</p>
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
//===============================================================
//header.php
//===============================================================
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Página Principal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <header class="bg-info d-flex align-items-center" style="height: 3cm;">
        <div class="container text-center">
            <h1>Sistema e-Commerce</h1>
        </div>
    </header>
    <nav class="navbar navbar-expand-lg p-0 navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="principal.php">Home</a>
            <a class="navbar-brand" href="usuarios_cadastro.php">Usuários</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <form method="POST" action="">
                            <button class="btn btn-link nav-link text-white" name="logout" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
//===============================================================
//index.php
//===============================================================
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Sistema</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="w-25 p-3">
        <h2>Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input class="form-control" type="password" name="senha" required>
            </div>
            <input type="submit" value="Entrar" class="btn btn-primary btn-block">   
        </form>
    </div>
</body>
</html>
//===============================================================
//login.php
//===============================================================
<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara e executa a consulta na tabela de usuários
    $stmt = $conn->prepare("SELECT nome FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nome);
        $stmt->fetch();
        
        //Registra o usuário na sessão
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $nome;

        header("Location: principal.php");
        exit();
    } else {
        echo "Login ou senha inválidos. Tente novamente.";
    }
    $stmt->close();
}
$conn->close();
?>
//===============================================================
//logout.php
//===============================================================
<?php
session_start();
session_unset();
session_destroy();
header("Location: index.php");
exit();
?>
//===============================================================
//principal_controller.php
//===============================================================
<?php
//Prepara pa gerenciar a sessão
session_start();

// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Armazena informações do usuário
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

// Função para lidar com o logout
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
//===============================================================
//principal.php
//===============================================================
<?php include 'principal_controller.php'; ?>
<?php include 'header.php'; ?>

<div class="flex-grow-1">
        <!-- Conteúdo da página vai aqui -->
        <h2>Olá, <?php echo htmlspecialchars($nome); ?>!</h2>

        <form method="POST" action="">
            <input type="submit" name="logout" value="Logout">
        </form>
    </div>


<?php include 'footer.php'; ?>
//===============================================================
//usuarios_cadastro.php
//===============================================================
<?php
include 'usuarios_controller.php';

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
    <h2>Cadastro de Usuários</h2>
    <form method="POST" action="">
        <input type="hidden" id="id" name="id" value="<?php echo $userToEdit['id'] ?? ''; ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $userToEdit['nome'] ?? ''; ?>" required><br><br>
        
        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $userToEdit['telefone'] ?? ''; ?>" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $userToEdit['email'] ?? ''; ?>" required><br><br>
        
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required><br><br>
        
        <button type="submit" name="save">Salvar</button>
        <button type="submit" name="update">Atualizar</button>
        <button type="button" onclick="clearForm()">Novo</button>
    </form>

    <h2>Usuários Cadastrados</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <!--Faz um loop FOR no resultset de usuários e preenche a tabela-->
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['nome']; ?></td>
                <td><?php echo $user['telefone']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <a href="?edit=<?php echo $user['id']; ?>">Editar</a>
                    <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
//===============================================================
//usuarios_controller.php
//===============================================================
<?php
include 'db.php';

function saveUser($nome, $telefone, $email, $senha) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, telefone, email, senha) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nome, $telefone, $email, $senha);
    return $stmt->execute();
}

function getUsers() {
    global $conn;
    $result = $conn->query("SELECT * FROM usuarios");
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getUser($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUser($id, $nome, $telefone, $email, $senha) {
    global $conn;
    $stmt = $conn->prepare("UPDATE usuarios SET nome = ?, telefone = ?, email = ?, senha = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $nome, $telefone, $email, $senha, $id);
    return $stmt->execute();
}

function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['save'])) {
        saveUser($_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['senha']);
    } elseif (isset($_POST['update'])) {
        updateUser($_POST['id'], $_POST['nome'], $_POST['telefone'], $_POST['email'], $_POST['senha']);
    }
}

// Processamento da exclusão
if (isset($_GET['delete'])) {
    deleteUser($_GET['delete']);
}
?>
