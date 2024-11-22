<?php
include 'db.php';

// Função para salvar um novo produto
function saveProduct($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;

    // Definir a pasta onde a imagem será armazenada
    $targetDir = "img/";

    // Verificar se a pasta existe; caso contrário, criar
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $targetFile = $targetDir . basename($url_img["name"]);

    // Mover o arquivo para o diretório
    if (!move_uploaded_file($url_img["tmp_name"], $targetFile)) {
        die("Erro ao salvar o arquivo. Verifique as permissões da pasta 'img'.");
    }

    // Definir o valor de ativo (caso o checkbox não tenha sido marcado, é 0)
    $ativo = isset($ativo) ? 1 : 0;

    $stmt = $conn->prepare("INSERT INTO produtos (nome, descricao, marca, modelo, valorunitario, categoria, url_img, ativo) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdsis", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $targetFile, $ativo);

    if (!$stmt->execute()) {
        die("Erro ao salvar o produto.");
    }
    return true;
}


// Função para atualizar um produto existente
function updateProduct($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo) {
    global $conn;
    $targetFile = "";

    if (!empty($url_img["name"])) {
        // Se uma nova imagem foi enviada
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($url_img["name"]);

        if (!move_uploaded_file($url_img["tmp_name"], $targetFile)) {
            return false; // Retorna falso caso o upload da imagem falhe
        }
    } else {
        // Mantém o caminho da imagem atual
        $stmt = $conn->prepare("SELECT url_img FROM produtos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $targetFile = $result['url_img'];
    }

    // Atualiza os dados no banco
    $stmt = $conn->prepare("UPDATE produtos SET nome = ?, descricao = ?, marca = ?, modelo = ?, valorunitario = ?, categoria = ?, url_img = ?, ativo = ? WHERE id = ?");
    $stmt->bind_param("ssssdsisi", $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $targetFile, $ativo, $id);
    return $stmt->execute();
}

// Função para excluir um produto
function deleteProduct($id) {
    global $conn;

    // Remove o registro do banco de dados
    $stmt = $conn->prepare("DELETE FROM produtos WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

// Função para obter todos os produtos ativos
function getProducts() {
    global $conn;

    $result = $conn->query("SELECT * FROM produtos WHERE ativo = 1");
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

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $valorunitario = $_POST['valorunitario'];
    $categoria = $_POST['categoria'];
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    $url_img = $_FILES['url_img'];

    if (isset($_POST['save'])) {
        // Cadastra um novo produto
        if (saveProduct($nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo)) {
            header("Location: principal.php");
            exit();
        } else {
            echo "Erro ao salvar o produto.";
        }
    } elseif (isset($_POST['update'])) {
        // Atualiza um produto existente
        $id = $_POST['id'];
        if (updateProduct($id, $nome, $descricao, $marca, $modelo, $valorunitario, $categoria, $url_img, $ativo)) {
            header("Location: principal.php");
            exit();
        } else {
            echo "Erro ao atualizar o produto.";
        }
    }
}

// Excluir produto
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (deleteProduct($id)) {
        header("Location: principal.php");
        exit();
    } else {
        echo "Erro ao excluir o produto.";
    }
}
?>
