<?php
include 'db.php';

// Função para salvar o produto no banco de dados
function saveProduct($nome, $descricao, $modelo, $valorunitario, $categoria, $marca, $urlImg, $ativo) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO produtos 
    (nome, descricao, marca, modelo, valorunitario, categoria, ativo, url_img)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $ativo, $urlImg);
    return $stmt->execute();
}

// Função para buscar todos os produtos 
function getProducts() {
    global $conn;
    $result = $conn->query("SELECT * FROM produtos");
    return $result->fetch_all(MYSQLI_ASSOC);
}
// Função para obter um produto específico
function getProduct($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Função para atualizar um produto
function updateProduct($id,$nome, $descricao, $modelo, $preco, $categoria, $marca, $urlImg, $ativo) {
    global $conn;
    $stmt = $conn->prepare("UPDATE produtos
    SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorunitario = ?, categoria = ?, ativo = ?, url_img = ?
    WHERE id = ?");
    
    // Aqui estamos adicionando a variável $id ao bind_param
    $stmt->bind_param("ssssssssi", $nome, $descricao, $marca, $modelo, $preco, $categoria, $ativo, $urlImg, $id);
    return $stmt->execute();
}

// Função para excluir um produto
function deleteProduct($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Processar o formulário de envio
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    if (isset($_POST['save'])) {
        saveProduct($_POST['nome'], $_POST['descricao'], $_POST['modelo'], floatval($_POST['valorunitario']), $_POST['categoria'], $_POST['marca'], $_POST['url_img'], $ativo);
    } elseif (isset($_POST['update'])) {
        updateProduct(intval($_POST['id']), $_POST['nome'], $_POST['descricao'], $_POST['modelo'], floatval($_POST['valorunitario']), $_POST['categoria'], $_POST['marca'], $_POST['url_img'], $ativo);
    }
}

// Excluir produto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    deleteProduct($id);
    header("Location: principal.php");
    exit();
}
?>
