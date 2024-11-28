<?php
include 'db.php';

// Verifica se a sessão já foi iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Armazena informações do usuário
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];

// Função para obter os produtos do banco de dados
function getProdutos() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Remover um produto do carrinho
if (isset($_GET['action']) && $_GET['action'] == 'remover' && isset($_GET['id_produto'])) {
    $id_produto = (int)$_GET['id_produto'];
    unset($_SESSION['carrinho'][$id_produto]);
    header("Location: shopcart.php");
    exit();
}

// Alterar a quantidade de um produto no carrinho
if (isset($_POST['action']) && $_POST['action'] == 'alterar' && isset($_POST['id_produto']) && isset($_POST['quantidade'])) {
    $id_produto = (int)$_POST['id_produto'];
    $quantidade = (int)$_POST['quantidade'];

    if ($quantidade <= 0) {
        unset($_SESSION['carrinho'][$id_produto]);  // Se quantidade for 0 ou negativa, remove o item
    } else {
        $_SESSION['carrinho'][$id_produto]['quantidade'] = $quantidade;
        $_SESSION['carrinho'][$id_produto]['subtotal'] = $quantidade * $_SESSION['carrinho'][$id_produto]['preco'];
    }
    header("Location: shopcart.php");
    exit();
}

// Função para obter um produto por ID
function getProdutoPorId($id_produto) {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos WHERE id = $id_produto");
    return $result->fetch_assoc();
}

// Calcular o total do carrinho
function calcularTotalCarrinho() {
    $total = 0;
    foreach ($_SESSION['carrinho'] as $item) {
        $total += $item['subtotal'];
    }
    return $total;
}

?>