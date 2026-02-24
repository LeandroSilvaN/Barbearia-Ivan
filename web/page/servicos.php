<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Serviços - Barbearia Ivan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../styles/servicos.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="../../index.php"><strong>Barbearia Ivan</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="menu">
                <ul class="navbar-nav">

                    <div class="mx-5 gap-2 d-flex">
                        <li class="nav-item border rounded hover">
                            <a class="nav-link" href="page/auth/login.php">Login</a>
                        </li>
                        <li class="nav-item border rounded hover">
                            <a class="nav-link" href="page/auth/register.php">Cadastra-se</a>
                        </li>
                    </div>

                    <li class="nav-item"><a class="nav-link" href="/index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="servicos.php">Serviços</a></li>
                    <li class="nav-item"><a class="nav-link" href="/page/produtos.php">Produtos</a></li>
                    <li class="nav-item"><a class="nav-link" href="/page/sobre.php">Sobre</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid text-center p-0 m-0">
        <div class="position-relative">
            <img src="../assets/img/principal.jpg" class="img-fluid w-100" alt="Título Serviços">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
                <h1 class="fw-bold">Serviços</h1>
            </div>
        </div>
    </div>

    <div class="container my-5 text-center">
        <div class="row g-4 justify-content-center">
            <div class="col-md-5 col-10">
                <img src="../assets/img/imagem3.jpeg" class="img-fluid rounded shadow-sm" alt="Serviço 1">
            </div>
            <div class="col-md-5 col-10">
                <img src="../assets/img/imagem2.jpg" class="img-fluid rounded shadow-sm" alt="Serviço 2">
            </div>
        </div>
    </div>

    <div class="container my-5">
        <h4 class="mb-4">Agendamentos</h4>

        <div class="d-flex justify-content-center gap-4 ">
            <div class="card col vertical-card" style="width: 18rem;">
                <img src="../assets/img/exemplo1.jpg" alt="Corte" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Corte</h5>
                    <p class="text-muted">R$ 40,00</p>
                    <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                        class="btn btn-dark">Agendar</a>
                </div>
            </div>

            <div class="card col vertical-card" style="width: 18rem;">
                <img src="../assets/img/exemplo2.jpg" alt="Sobrancelha" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Sobrancelha</h5>
                    <p class="text-muted">R$ 10,00</p>
                    <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                        class="btn btn-dark">Agendar</a>
                </div>
            </div>

            <div class="card col vertical-card" style="width: 18rem;">
                <img src="../assets/img/exemplo3.jpg" alt="Barba" class="card-img-top">
                <div class="card-body text-center">
                    <h5 class="card-title">Barba</h5>
                    <p class="text-muted">R$ 25,00</p>
                    <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                        class="btn btn-dark">Agendar</a>
                </div>
            </div>

        </div>
    </div>

    <div class="container my-5">
        <h4 class="mb-3 text-center">Agendamentos</h4>
        <p class="text-muted text-center mb-4">Outros</p>
        <div class="row g-4">
            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center">
                    <img src="../assets/img/exemplo4.jpg" alt="Corte + Sobrancelha">
                    <div class="card-body">
                        <h6 class="card-title">Corte + Sobrancelha</h6>
                        <p class="text-muted">R$ 45,00</p>
                        <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                            class="btn btn-dark btn-sm">Agendar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center">
                    <img src="../assets/img/exemplo5.jpg" alt="Corte + Barba">
                    <div class="card-body">
                        <h6 class="card-title">Corte + Barba</h6>
                        <p class="text-muted">R$ 55,00</p>
                        <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                            class="btn btn-dark btn-sm">Agendar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center">
                    <img src="../assets/img/exemplo6.jpg" alt="Corte + Sobrancelha + Barba">
                    <div class="card-body">
                        <h6 class="card-title">Corte + Sobrancelha + Barba</h6>
                        <p class="text-muted">R$ 65,00</p>
                        <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                            class="btn btn-dark btn-sm">Agendar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center">
                    <img src="../assets/img/exemplo7.jpg" alt="Corte Infantil">
                    <div class="card-body">
                        <h6 class="card-title">Corte Infantil</h6>
                        <p class="text-muted">R$ 30,00</p>
                        <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                            class="btn btn-dark btn-sm">Agendar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center">
                    <img src="../assets/img/exemplo8.jpg" alt="Lavagem e Hidratação">
                    <div class="card-body">
                        <h6 class="card-title">Lavagem e Hidratação</h6>
                        <p class="text-muted">R$ 60,00</p>
                        <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                            class="btn btn-dark btn-sm">Agendar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6">
                <div class="card service-card text-center">
                    <img src="../assets/img/exemplo9.jpg" alt="Química">
                    <div class="card-body">
                        <h6 class="card-title">Química</h6>
                        <p class="text-muted">R$ 90,00</p>
                        <a href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"
                            class="btn btn-dark btn-sm">Agendar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 class="text-center">Redes Sociais</h4>
    <div class="d-flex justify-content-center mb-2">
        <div class="btn btn-success">
            <a class="me-2" href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank"><img
                    src="../assets/img/whatsapp.png" alt="Ícone WhatsApp" /></a>
            <a class="text-light link-offset-2 link-underline link-underline-opacity-0"
                href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank">WhatsApp</a>
        </div>
    </div>
    <div class="pb-4 text-center">
        <h4>Endereço</h4>
        <p>Rua Mário Alves de Souza Vieira, 21 CEP: 04814-520 <br /> Jardim Guanhembu - São Paulo/SP</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>