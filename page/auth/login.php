<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Barbearia Ivan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/auth.css">
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="card login-card shadow p-4" style="max-width: 400px; width: 100%;">
            
            <div class="text-center mb-4">
                <h2 class="fw-bold">Login</h2>
                <p class="text-muted">Acesse sua conta</p>
            </div>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" placeholder="Digite sua senha" required>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <small>
                        Não tem conta? 
                        <a href="register.php" class="text-decoration-none fw-semibold">Cadastrar-se</a>
                    </small>
                </div>

                <button type="submit" class="btn btn-custom w-100">
                    Entrar
                </button>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>