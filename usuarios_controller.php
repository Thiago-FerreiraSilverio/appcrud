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
