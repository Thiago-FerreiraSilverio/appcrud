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