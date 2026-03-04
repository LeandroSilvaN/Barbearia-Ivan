<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Barbearia Ivan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="../styles/produtos.css" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php"><strong>Barbearia Ivan</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="menu">
                <ul class="navbar-nav">

                    <div class="d-flex justify-content-center justify-content-lg-end mt-3 mt-lg-0 ms-lg-3"
                        id="navbarNav">
                        <div class="d-flex gap-2 me-5">
                            <a href="auth/login.php" class="btn btn-dark">Agendar Horário</a>
                        </div>
                    </div>

                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="../page/servicos.php">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link active" href="../page/produtos.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="../page/sobre.php">Sobre</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid text-center p-0 m-0">
        <div class="position-relative">
            <img src="../assets/img/principal.jpg" class="img-fluid w-100" alt="Título Produtos">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
                <h1 class="fw-bold">Produtos</h1>
            </div>
        </div>
    </div>

    <section>
        <h3>Produtos á venda</h3>
        <div class="produtos">
            <?php foreach($result as $res): ?>
            <div class="produto">
                <img src="../assets/img/<?= $res[" imagem"]?>" alt=" Shampoo Ice">
                <h4>
                    <?= $res["nome"] ?>
                </h4>
                <p>
                    R$
                    <?= number_format($res["valorCentavos"] / 100, 2) ?>
                </p>
            </div> 
            <?php endforeach; ?> 
        </div>
    </section>

    <footer>
        <h4 class="text-center">Redes Sociais</h4>
        <div class="d-flex justify-content-center mb-2">
            <div class="btn btn-success">
                <a class="me-2" href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"><img
                        src="../assets/img/whatsapp.png" alt="Ícone WhatsApp" /></a>
                <a class="text-light link-offset-2 link-underline link-underline-opacity-0"
                    href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank">WhatsApp</a>
            </div>
        </div>
        <h4>Endereço</h4>
        <p>Rua Mário Alves de Souza Vieira, 21<br>Jardim Guanhembu - São Paulo/SP</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
        </script>
</body>

</html>
