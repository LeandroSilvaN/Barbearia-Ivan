<?php
session_start();

require_once 'page/config/conection.php';

$sql_servicos = "
SELECT *
FROM servico
WHERE status='ATIVO'
";

$resultado_servicos = mysqli_query($conn, $sql_servicos);

$data = "";
$servico_selecionado = "";
$horarios_ocupados = [];

$numero_dia = -1;

$hora_inicio = 9;
$hora_fim = 19;

if (isset($_POST['servico_id'])) {
    $servico_selecionado = $_POST['servico_id'];
}

if (isset($_POST['data'])) {

    $data = $_POST['data'];

    $numero_dia = date('w', strtotime($data));

    if ($numero_dia == 6) {

        $hora_fim = 14;

    }

    if ($numero_dia == 0) {

        $hora_inicio = 0;
        $hora_fim = 0;

    }

    $sql_data = "

    SELECT
    ag.horario,
    ser.duracao

    FROM agendamento ag

    INNER JOIN servico ser
    ON ag.servico_id=ser.id

    WHERE ag.data='$data'

    AND ag.status IN
    ('CONFIRMADO','PENDENTE')

    ";

    $resultado_data = mysqli_query($conn, $sql_data);

    while ($agendamento = mysqli_fetch_assoc($resultado_data)) {

        $horario_base = $agendamento['horario'];

        $duracao = $agendamento['duracao'];

        $blocos = ceil($duracao / 30);

        for ($i = 0; $i < $blocos; $i++) {

            $horario_bloqueado = date(
                'H:i:s',
                strtotime(
                    "+" . ($i * 30) . " minutes",
                    strtotime($horario_base)
                )
            );

            $horarios_ocupados[] = $horario_bloqueado;

        }

    }

}

if (isset($_POST['confirmar_agendamento'])) {

    $cliente_id = $_SESSION['id'];

    $servico_id = $_POST['servico_id'];

    $data_agendamento = $_POST['data'];

    $horario = $_POST['horario'];

    $observacoes = $_POST['observacoes'];

    $sql_preco = "
    SELECT preco
    FROM servico
    WHERE id=$servico_id
    ";

    $resultado_preco = mysqli_query($conn, $sql_preco);

    $servico = mysqli_fetch_assoc($resultado_preco);

    $preco = $servico['preco'];

    $sql_insert = "

    INSERT INTO agendamento
    (
        data,
        horario,
        observacoes,
        status,
        cliente_id,
        servico_id,
        preco
    )

    VALUES
    (
        '$data_agendamento',
        '$horario',
        '$observacoes',
        'PENDENTE',
        '$cliente_id',
        '$servico_id',
        '$preco'
    )

    ";

    $resultado_insert = mysqli_query($conn, $sql_insert);

    if ($resultado_insert) {

        echo "

        <script>

        alert('Agendamento realizado com sucesso');

        window.location='index.php';

        </script>

        ";

    }

}

?>

<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barbearia Ivan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles/global.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');
        body.dark .navbar { background-color: #0b1220 !important; }
        body.dark .navbar-brand, body.dark .nav-link { color: #e6eef8 !important; }
        body.dark .nav-link:hover { color: #60a5fa !important; }

        body {
            font-family: "Poppins";
        }

        .foto-hover {
            transition: transform 0.3s;
            cursor: pointer;
        }

        .foto-hover:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body class="dark">
    <script src="assets/js/theme-toggle.js"></script>

    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: white;">
        <div class="container-fluid"> <a class="navbar-brand" href="index.php"><strong>Barbearia Ivan</strong></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"> <span
                    class="navbar-toggler-icon"></span> </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                        <div class="d-flex justify-content-center justify-content-lg-end mt-3 mt-lg-0 ms-lg-3"
                            id="navbarNav">
                            <div class="d-flex gap-2 me-5"> <?php if (isset($_SESSION['nome'])): ?>
                                    <div class="dropdown"> <button class="btn btn-dark dropdown-toggle" type="button"
                                            id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false"> Olá,
                                            <?php echo htmlspecialchars($_SESSION['nome']); ?> </button>
                                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">

                                            <li>
                                                <span class="dropdown-item disabled">
                                                    <?php echo htmlspecialchars($_SESSION['nome']); ?>
                                                </span>
                                            </li>

                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="page/cliente/perfil.php">
                                                    Perfil
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="page/cliente/meus_agendamentos.php">
                                                    Meus Agendamentos
                                                </a>
                                            </li>

                                            <li>
                                                <a class="dropdown-item" href="page/auth/logout.php">
                                                    Sair
                                                </a>
                                            </li>

                                        </ul>
                                    </div> <?php else: ?> <a href="page/auth/login.php" class="btn btn-dark">Agendar
                                        Horário</a> <?php endif; ?>
                                        <button id="theme-toggle" class="btn btn-outline-secondary ms-2" aria-label="Alternar tema">🌙</button>
                            </div>
                        </div>
                        <li class="nav-item"> <a class="nav-link active" href="index.php">Home</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="page/servicos.php">Serviços</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="page/produtos.php">Produtos</a> </li>
                        <li class="nav-item"> <a class="nav-link" href="page/sobre.php">Sobre</a> </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid text-center p-0 m-0">
        <div class="position-relative"> <img src="assets/img/principal.jpg" class="img-fluid w-100" alt="Título">
            <div class="position-absolute top-50 start-50 translate-middle text-white">
                <h1 class="fw-bold">Barbearia Ivan</h1>
            </div>
        </div>
    </div>
    <p class="mt-3 text-center">Onde o corte é clássico e o estilo é moderno!</p>
    <?php if (isset($_SESSION['nome'])): ?>

        <section id="agendamento" class="container my-5">

            <div class="card shadow p-4 mx-auto" style="max-width:600px;border-radius:15px;">

                <div class="text-center mb-4">

                    <h3 class="fw-bold">
                        Agendar Horário
                    </h3>

                    <p class="text-muted">

                        Olá,
                        <strong>

                            <?php echo $_SESSION['nome']; ?>

                        </strong>

                    </p>

                </div>

                <form method="POST">

                    <div class="mb-3">

                        <label class="form-label">

                            Serviço

                        </label>

                        <select class="form-select" name="servico_id" required>

                            <option selected disabled>

                                Selecione um serviço

                            </option>

                            <?php
                            mysqli_data_seek(
                                $resultado_servicos,
                                0
                            );

                            while ($servico = mysqli_fetch_assoc($resultado_servicos)):
                                ?>

                                <option value="<?php echo $servico['id']; ?>" <?php
                                   if (
                                       $servico_selecionado ==
                                       $servico['id']
                                   ) {

                                       echo "selected";

                                   }
                                   ?>>

                                    <?php echo $servico['nome']; ?>

                                </option>

                            <?php endwhile; ?>

                        </select>

                    </div>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Data

                            </label>

                            <input type="date" name="data" class="form-control" required min="<?php echo date('Y-m-d'); ?>"
                                value="<?php echo $data; ?>"
                                onchange="window.location.hash='agendamento'; this.form.submit();">

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Horário

                            </label>

                            <?php if (count($horarios_ocupados) < 21): ?>

                                <?php if ($numero_dia == 0): ?>

                                    <div class="alert alert-danger">

                                        Não atendemos aos domingos

                                    </div>

                                <?php else: ?>

                                    <select name="horario" class="form-select" required>

                                        <option selected disabled>

                                            Selecione um horário

                                        </option>

                                        <?php

                                        for (
                                            $hora = $hora_inicio;
                                            $hora <= $hora_fim;
                                            $hora++
                                        ) {

                                            $hora_formatada =
                                                str_pad(
                                                    $hora,
                                                    2,
                                                    '0',
                                                    STR_PAD_LEFT
                                                );

                                            $horario_cheio =
                                                $hora_formatada
                                                . ":00:00";

                                            if (
                                                !in_array(
                                                    $horario_cheio,
                                                    $horarios_ocupados
                                                )
                                            ) {
                                                ?>

                                                <option value="<?php echo $horario_cheio; ?>">

                                                    <?php echo $hora_formatada; ?>:00

                                                </option>

                                            <?php }

                                            if ($hora < $hora_fim) {

                                                $horario_meia =
                                                    $hora_formatada
                                                    . ":30:00";

                                                if (
                                                    !in_array(
                                                        $horario_meia,
                                                        $horarios_ocupados
                                                    )
                                                ) {
                                                    ?>

                                                    <option value="<?php echo $horario_meia; ?>">

                                                        <?php echo $hora_formatada; ?>:30

                                                    </option>

                                                <?php }
                                            }
                                        } ?>

                                    </select>

                                <?php endif; ?>

                            <?php else: ?>

                                <div class="alert alert-danger">

                                    Todos os horários estão ocupados

                                </div>

                            <?php endif; ?>

                        </div>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">

                            Observações

                        </label>

                        <textarea class="form-control" name="observacoes" rows="3"
                            placeholder="Alguma preferência?"></textarea>

                    </div>

                    <button type="submit" name="confirmar_agendamento" class="btn btn-dark w-100">

                        Confirmar Agendamento

                    </button>

                </form>

            </div>

        </section>

    <?php endif; ?>
    <h3 class="text-center">Horário de Funcionamento</h3>
    <div class="container table-responsive">
        <table class="table table-dark table-striped table-bordered w-100 mx-auto mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Dia</th>
                    <td>Segunda</td>
                    <td>Terça</td>
                    <td>Quarta</td>
                    <td>Quinta</td>
                    <td>Sexta</td>
                    <td>Sábado</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>Horário</th>
                    <td>09h às 19h</td>
                    <td>09h às 19h</td>
                    <td>09h às 19h</td>
                    <td>09h às 19h</td>
                    <td>09h às 19h</td>
                    <td>09h às 14h</td>
                </tr>
            </tbody>
        </table>
    </div>
    <h3 class="text-center">Galeria de Fotos</h3>
    <div class="container d-none d-md-block mb-4">
        <div class="row">
            <div class="col-md-4 mb-3"> <img src="assets/img/foto_home1.jpeg"
                    style="height: 200px; width: 100%; object-fit: cover;" class="img-fluid rounded foto-hover"
                    alt="foto 1"> </div>
            <div class="col-md-4 mb-3"> <img src="assets/img/foto_home2.jpeg"
                    style="height: 200px; width: 100%; object-fit: cover;" class="img-fluid rounded foto-hover"
                    alt="foto 2"> </div>
            <div class="col-md-4 mb-3"> <img style="height: 200px; width: 100%; object-fit: cover;"
                    src="assets/img/foto_home3.jpeg" class="img-fluid rounded foto-hover" alt="foto 3"> </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3"> <img src="assets/img/foto_home4.jpeg"
                    style="height: 200px; width: 100%; object-fit: cover;" class="img-fluid rounded foto-hover"
                    alt="foto 4"> </div>
            <div class="col-md-4 mb-3"> <img src="assets/img/foto_home5.jpeg"
                    style="height: 200px; width: 100%; object-fit: cover;" class="img-fluid rounded foto-hover"
                    alt="foto 5"> </div>
            <div class="col-md-4 mb-3"> <img src="assets/img/foto_home6.jpeg"
                    style="height: 200px; width: 100%; object-fit: cover;" class="img-fluid rounded foto-hover"
                    alt="foto 6"> </div>
        </div>
    </div>
    <div id="carouselFotos" class="carousel slide d-block d-md-none text-center mx-auto mb-4" data-bs-ride="carousel"
        style="max-width: 300px;">
        <div class="carousel-inner">
            <div class="carousel-item active"> <img src="assets/img/foto_home1.jpeg" class="d-block w-100 rounded"
                    alt="Foto 1"> </div>
            <div class="carousel-item"> <img src="assets/img/foto_home2.jpeg" class="d-block w-100 rounded foto-hover"
                    alt="foto 2"> </div>
            <div class="carousel-item"> <img src="assets/img/foto_home3.jpeg" class="d-block w-100 rounded" alt="foto 3">
            </div>
            <div class="carousel-item"> <img src="assets/img/foto_home4.jpeg" class="d-block w-100 rounded" alt="foto 4">
            </div>
            <div class="carousel-item"> <img src="assets/img/foto_home5.jpeg" class="d-block w-100 rounded" alt="foto 5">
            </div>
            <div class="carousel-item"> <img src="assets/img/foto_home6.jpeg" class="d-block w-100 rounded" alt="foto 6">
            </div>
        </div> <button class="carousel-control-prev" type="button" data-bs-target="#carouselFotos" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span> </button> <button class="carousel-control-next"
            type="button" data-bs-target="#carouselFotos" data-bs-slide="next"> <span
                class="carousel-control-next-icon"></span> </button>
    </div>
    <div class="d-flex justify-content-center mb-2">
        <div class="btn btn-success"> <a class="me-2" href="https://api.whatsapp.com/send?phone=5511940740247"
                target="_blank"><img src="assets/img/whatsapp.png" alt=Ícone WhatsApp" /></a> <a
                class="text-light link-offset-2 link-underline link-underline-opacity-0"
                href="https://api.whatsapp.com/send?phone=5511940740247" target="_blank">WhatsApp</a> </div>
    </div>
    <div class="pb-4 text-center">
        <h4>Endereço</h4>
        <p>Rua Mário Alves de Souza Vieira, 21 CEP: 04814-520 <br /> Jardim Guanhembu - São Paulo/SP</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">

        window.addEventListener(
            'load',
            function () {

                if (
                    window.location.hash
                    ==
                    '#agendamento'
                ) {

                    document
                        .getElementById(
                            'agendamento'
                        )
                        .scrollIntoView({

                            behavior: 'smooth'

                        });

                }

            }
        );

    </script>
</body>

</html>