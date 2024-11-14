<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body class="d-flex align-items-center justify-content-center bg-light" style="height: 100vh;">
    <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-header bg-primary text-white text-center">
            <h3>Login</h3>
        </div>
        <div class="card-body">
            <form action="login.php" method="POST">
                <!-- Campo Email -->
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                </div>

                <!-- Campo Senha -->
                <div class="form-group mb-3">
                    <label for="senha" class="form-label">Senha:</label>
                    <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
                </div>

                <!-- Botão Entrar -->
                <button type="submit" class="btn btn-primary btn-block w-100">Entrar</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <small class="text-muted">© 2024 Sistema e-Commerce</small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
