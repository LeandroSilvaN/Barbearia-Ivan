<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | Barbearia Ivan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/auth.css">
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">

        <div class="card auth-card shadow p-4" style="max-width: 450px; width: 100%;">

            <div class="text-center mb-4">
                <h2 class="fw-bold">Criar Conta</h2>
                <p class="text-muted">Cadastre-se para continuar</p>
            </div>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" placeholder="Digite seu nome" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Digite seu email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Telefone</label>
                    <input type="text" name="telefone" class="form-control" placeholder="(11) 99999-9999" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" placeholder="Crie uma senha" required>
                </div>

                <div class="mb-3">
                    <small>
                        Já tem conta?
                        <a href="login.php" class="text-decoration-none fw-semibold">
                            Entrar
                        </a>
                    </small>
                </div>

                <button type="submit" class="btn btn-custom w-100">
                    Criar Conta
                </button>

            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>