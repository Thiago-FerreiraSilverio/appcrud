<?php include 'principal_controller.php'; ?>
<?php include 'header.php'; ?>
<?php
// Verifica se o usuário está registrado na sessão (logado)
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>
    <div class="flex-grow-1">
        <!-- Conteúdo da página vai aqui -->
        <h2>Olá , <?php echo htmlspecialchars($nome); ?>!</h2>
    </div>


<?php include 'footer.php'; ?>