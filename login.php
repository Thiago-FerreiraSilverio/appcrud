<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara e executa a consulta na tabela de usuários
    $stmt = $conn->prepare("SELECT id, nome FROM usuarios WHERE email = ? AND senha = ?");
    $stmt->bind_param("ss", $email, $senha);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $nome);
        $stmt->fetch();
        
        //Registra o usuário na sessão
        $_SESSION['email'] = $email;
        $_SESSION['nome'] = $nome;
        $_SESSION['id'] = $id;

        header("Location: principal.php");
        exit();
    } else {
        echo "Login ou senha inválidos. Tente novamente.";
    }
    $stmt->close();
}
$conn->close();
?>
