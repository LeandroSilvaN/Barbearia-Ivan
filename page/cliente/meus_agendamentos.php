<?php

session_start();

include("../config/conection.php");

if (!isset($_SESSION['id'])) {

    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

$sql = "

SELECT

    ag.id,
    ag.data,
    ag.horario,
    ag.status,
    ag.observacoes,

    ser.nome AS servico,
    ag.preco

FROM agendamento ag

INNER JOIN servico ser
ON ag.servico_id = ser.id

WHERE ag.cliente_id = $id

ORDER BY
ag.data DESC,
ag.horario DESC

";

$resultado = mysqli_query($conn, $sql);

$agendamentos = [];

while ($linha = mysqli_fetch_assoc($resultado)) {

    $agendamentos[] = $linha;

}

usort($agendamentos, function ($a, $b) {

    $ordem = [

        'PENDENTE' => 1,
        'CONFIRMADO' => 2,
        'CANCELADO' => 3,
        'FINALIZADO' => 4

    ];

    return $ordem[$a['status']] <=> $ordem[$b['status']];

});

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>

        Meus Agendamentos

    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {

            background: #f8f9fa;

        }
    </style>

</head>

<body>

    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <a class="navbar-brand" href="../../index.php">
                <strong>Barbearia Ivan</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

                <span class="navbar-toggler-icon">

                </span>

            </button>

            <div class="collapse navbar-collapse justify-content-end" id="menu">

                <ul class="navbar-nav">

                    <div class="d-flex justify-content-center justify-content-lg-end mt-3 mt-lg-0 ms-lg-3">

                        <div class="d-flex gap-2 me-5">

                            <div class="dropdown">

                                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">

                                    Olá,
                                    <?php echo htmlspecialchars($_SESSION['nome']); ?>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <span class="dropdown-item disabled">

                                            <?php echo htmlspecialchars($_SESSION['email']); ?>

                                        </span>

                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="perfil.php">

                                            Perfil

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="meus_agendamentos.php">

                                            Meus Agendamentos

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="../auth/logout.php">

                                            Sair

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                    <li class="nav-item">

                        <a class="nav-link" href="../../index.php">

                            Home

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../servicos.php">

                            Serviços

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../produtos.php">

                            Produtos

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../sobre.php">

                            Sobre

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <div class="container mt-5">

        <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">

            <div>

                <h1 class="h2">

                    Meus Agendamentos

                </h1>

                <h5 class="text-muted">

                    <?= $_SESSION['nome'] ?>

                </h5>

            </div>


        </div>

        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover">

                        <thead>

                            <tr>

                                <th>

                                    Data/Hora

                                </th>

                                <th>

                                    Serviço

                                </th>

                                <th>

                                    Status

                                </th>

                                <th>

                                    Preço

                                </th>

                                <th>

                                    Ações

                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($agendamentos as $agendamento) { ?>

                                <tr>

                                    <td>

                                        <?= date(
                                            'd/m/Y',
                                            strtotime($agendamento['data'])
                                        )
                                            ?>

                                        às

                                        <?= substr(
                                            $agendamento['horario'],
                                            0,
                                            5
                                        )
                                            ?>

                                    </td>

                                    <td>

                                        <?= $agendamento['servico'] ?>

                                    </td>

                                    <td>

                                        <?php if ($agendamento['status'] == "PENDENTE") { ?>

                                            <span class="badge bg-warning">

                                                Pendente

                                            </span>

                                        <?php } ?>

                                        <?php if ($agendamento['status'] == "CONFIRMADO") { ?>

                                            <span class="badge bg-success">

                                                Confirmado

                                            </span>

                                        <?php } ?>

                                        <?php if ($agendamento['status'] == "FINALIZADO") { ?>

                                            <span class="badge bg-primary">

                                                Finalizado

                                            </span>

                                        <?php } ?>

                                        <?php if ($agendamento['status'] == "CANCELADO") { ?>

                                            <span class="badge bg-danger">

                                                Cancelado

                                            </span>

                                        <?php } ?>

                                    </td>

                                    <td>

                                        R$

                                        <?= number_format(
                                            $agendamento['preco'],
                                            2,
                                            ',',
                                            '.'
                                        )
                                            ?>

                                    </td>

                                   
                                    <td>

                                        <?php
                                        $data_agendamento = strtotime($agendamento['data']);
                                        $hoje = strtotime(date('Y-m-d'));
                                        ?>

                                        <!-- OBSERVAÇÕES -->
                                        <button type="button" class="btn btn-sm btn-light border text-dark"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalObservacao<?= $agendamento['id'] ?>" title="Observações">
                                            <i class="bi bi-info-circle"></i>
                                        </button>

                                        <?php if (

                                            (
                                                $agendamento['status'] == "PENDENTE"
                                                ||
                                                $agendamento['status'] == "CONFIRMADO"
                                            )

                                            &&

                                            $data_agendamento >= $hoje

                                        ) { ?>

                                            <!-- EDITAR -->
                                            <a class="btn btn-sm btn-light border text-dark"
                                                href="editar_agendamento.php?id=<?= $agendamento['id'] ?>" title="Editar">

                                                <i class="bi bi-pencil"></i>

                                            </a>

                                            <!-- CANCELAR -->
                                            <a class="btn btn-sm btn-danger"
                                                href="cancelar_agendamento.php?id=<?= $agendamento['id'] ?>" onclick="return confirm(
'Deseja realmente cancelar este agendamento?'
)" title="Cancelar">

                                                <i class="bi bi-x-circle"></i>

                                            </a>

                                        <?php } ?>

                                    </td>


                                </tr>


                                <!-- MODAL OBSERVAÇÃO -->

                                <!-- MODAL OBSERVAÇÃO -->

                                <div class="modal fade" id="modalObservacao<?= $agendamento['id'] ?>" tabindex="-1">

                                    <div class="modal-dialog">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title">

                                                    Observações

                                                </h5>

                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

                                            </div>

                                            <div class="modal-body">

                                                <?php if (!empty($agendamento['observacoes'])) { ?>

                                                    <?= nl2br($agendamento['observacoes']) ?>

                                                <?php } else { ?>

                                                    <span class="text-muted">

                                                        Nenhuma observação.

                                                    </span>

                                                <?php } ?>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>