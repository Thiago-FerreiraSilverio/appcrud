<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'shopcart_controller.php';

?>

<?php include 'header.php'; ?>

<div class="container p-2">
    <h3>Carrinho de Compras</h3>

    <?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
        <table border="1" class="table table-bordered table-light table-striped table-hover table-sm">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrinho'] as $id_produto => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome_produto']); ?></td>
                        <td>
                            <form method="POST" action="shopcart_controller.php">
                                <input type="hidden" name="id_produto" value="<?php echo $id_produto; ?>">
                                <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1" max="10">
                                <button type="submit" name="action" value="alterar" class="btn btn-sm btn-warning">Alterar</button>
                            </form>
                        </td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                        <td><a href="shopcart_controller.php?action=remover&id_produto=<?php echo $id_produto; ?>" class="btn btn-danger btn-sm">Excluir</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h3>Total: R$ <?php echo number_format(calcularTotalCarrinho(), 2, ',', '.'); ?></h3>

        <a href="shopcart_finalizar_compra.php" class="btn btn-success">Confirmar Compra</a>
        <a href="principal.php" class="btn btn-primary">Continuar Compra</a>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
        <a href="principal.php" class="btn btn-primary">Voltar</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>