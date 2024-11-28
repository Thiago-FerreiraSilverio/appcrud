<?php
session_start();

// Verifica se há algum erro armazenado na sessão
if (isset($_SESSION['erro_compra'])) {
    $erro = $_SESSION['erro_compra'];
    unset($_SESSION['erro_compra']);  // Limpa o erro após exibição
} else {
    // Se não houver erro, redireciona para a página inicial
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro na Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            color: #721c24;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            border: 1px solid #f5c6cb;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #721c24;
        }
        p {
            font-size: 16px;
        }
        a {
            color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Erro ao Processar a Compra</h1>
        <p>Ocorreu um erro ao tentar finalizar seu pedido. Detalhes do erro:</p>
        <p><strong><?php echo $erro; ?></strong></p>
        <p><a href="index.php">Clique aqui para voltar à página inicial.</a></p>
    </div>
</body>
</html>