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
        
        // Registra o usuário na sessão
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $nome;

        header("Location: principal.php");
        exit();
    } else {
        // Mensagem de erro com estilização Bootstrap
        echo '<!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Login Inválido</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        </head>
        <body class="d-flex align-items-center justify-content-center bg-light" style="height: 100vh;">
            <div class="text-center">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Erro no Login!</h4>
                    <p>O email ou a senha informados estão incorretos. Por favor, tente novamente.</p>
                </div>
                <a href="index.php" class="btn btn-primary">Voltar para a Página de Login</a>
            </div>
        </body>
        </html>';
    }
    $stmt->close();
}
$conn->close();
?>
