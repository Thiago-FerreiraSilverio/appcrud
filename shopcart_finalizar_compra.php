<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Incluir funções de gerenciamento do carrinho
include 'shopcart_controller.php';

?>

<?php include 'header.php'; ?>

<div class="container p-2">
    <h4>Finalização da Compra - Resumo do Pedido</h4>
    <?php if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0): ?>
        <table class="table table-bordered table-warning table-striped table-hover table-sm">
            <thead class="table-dark">
                <tr>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['carrinho'] as $id_produto => $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['nome_produto']); ?></td>
                        <td><?php echo $item['quantidade']; ?></td>
                        <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                        <td>R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Total da Compra: R$ <?php echo number_format(calcularTotalCarrinho(), 2, ',', '.'); ?></h4>

        <form method="POST" action="shopcart_processar_compra.php">
            <input type="hidden" name="acao" value="finalizar">
            <button type="submit" class="btn btn-success">Finalizar Compra</button>
            <a href="shopcart.php" class="btn btn-warning">Voltar ao Carrinho</a>
        </form>

    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
        <a href="principal.php" class="btn btn-primary">Voltar para os Produtos</a>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
