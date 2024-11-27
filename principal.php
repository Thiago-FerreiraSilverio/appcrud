<?php
include 'produtos_controller.php'; // Certifique-se de ajustar o caminho corretamente
include 'header.php';

// Obtém os produtos para exibição
$products = getProducts();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Produtos Disponíveis</h1>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="img-card" style="width:100%; height:250px; object-fit:cover; border-radius:5px;">
                        <img style="width:100%; height:250px; object-fit:contain; border-radius:5px;" src="<?php echo $product['url_img']; ?>" class="card-img-top" alt="<?php echo $product['nome']; ?>">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['nome']; ?></h5>
                        <p class="card-text"><?php echo $product['descricao']; ?></p>
                        <p class="card-text"><strong>Marca:</strong> <?php echo $product['marca']; ?></p>
                        <p class="card-text"><strong>Modelo:</strong> <?php echo $product['modelo']; ?></p>
                        <p class="card-text"><strong>Preço:</strong> R$ <?php echo number_format($product['valorunitario'], 2, ',', '.'); ?></p>
                        <td class="acoes">
                        <a href="carrinho.php?add=<?php echo $product['id']; ?>" class="btn btn-primary">Comprar</a>
                        </td>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
