<?php

require_once 'config.php';
require_once 'includes/header.php';

$id = $_GET['id'];

$sql_agendamento = "
SELECT *
FROM agendamento
WHERE id = $id
";

$resultado_agendamento = mysqli_query($conn, $sql_agendamento);

$agendamento = mysqli_fetch_assoc($resultado_agendamento);

$sql_servicos = "
SELECT *
FROM servico
WHERE status = 'ATIVO'
";

$resultado_servicos = mysqli_query($conn, $sql_servicos);

$sql_clientes = "
SELECT *
FROM usuarios
WHERE role = 'USER'
AND status = 'ATIVO'
";

$resultado_clientes = mysqli_query($conn, $sql_clientes);

$data = $agendamento['data'];

$cliente_selecionado = $agendamento['cliente_id'];

$servico_selecionado = $agendamento['servico_id'];

$horario_selecionado = $agendamento['horario'];

$observacoes = $agendamento['observacoes'];

$status = $agendamento['status'];

$horarios_ocupados = [];

$numero_dia = date('w', strtotime($data));

$hora_inicio = 9;

$hora_fim = 19;

if ($numero_dia == 6) {

    $hora_fim = 14;

}

if ($numero_dia == 0) {

    $hora_inicio = 0;

    $hora_fim = 0;

}

if (isset($_POST['data'])) {

    $data = $_POST['data'];

    $cliente_selecionado = $_POST['cliente_id'];

    $servico_selecionado = $_POST['servico_id'];

    $horario_selecionado = $_POST['horario'] ?? '';

    $observacoes = $_POST['observacoes'];

    $status = $_POST['status'];

    $numero_dia = date('w', strtotime($data));

    $hora_inicio = 9;

    $hora_fim = 19;

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
    ON ag.servico_id = ser.id

WHERE
    ag.data = '$data'

    AND ag.status IN (
        'CONFIRMADO',
        'PENDENTE'
    )

    AND ag.id != $id
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

    $resultado_data = mysqli_query($conn, $sql_data);

    while ($horario = mysqli_fetch_assoc($resultado_data)) {

        $horarios_ocupados[] = $horario['horario'];

    }

}

if (isset($_POST['editar'])) {

    $cliente_id = $_POST['cliente_id'];

    $servico_id = $_POST['servico_id'];

    $data_agendamento = $_POST['data'];

    $horario = $_POST['horario'];

    $observacoes = $_POST['observacoes'];

    $status = $_POST['status'];

    $sql_update = "
    UPDATE agendamento SET

        data = '$data_agendamento',
        horario = '$horario',
        observacoes = '$observacoes',
        status = '$status',
        cliente_id = '$cliente_id',
        servico_id = '$servico_id'

    WHERE id = $id
    ";

    $sql_verificar = "
SELECT id
FROM agendamento
WHERE data = '$data_agendamento'
AND horario = '$horario'
AND status IN ('PENDENTE', 'CONFIRMADO')
AND id != $id
";

    $resultado_verificar = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {

        echo "
    <div class='alert alert-danger text-center'>
        Este horário já está ocupado.
    </div>
    ";

    } else {

        $resultado_update = mysqli_query($conn, $sql_update);
    }

    if ($resultado_update) {

        echo "
        <script>

            alert('Agendamento atualizado com sucesso!');

            window.location.href = 'agendamentos.php';

        </script>
        ";

    } else {

        echo "
        <div class='alert alert-danger text-center'>
            Erro ao atualizar agendamento.
        </div>
        ";

    }

}

?>

<section class="container my-5">

    <div class="card shadow p-4 mx-auto" style="max-width: 600px; border-radius: 15px;">

        <div class="text-center mb-4">

            <h3 class="fw-bold">

                Editar Agendamento

            </h3>

        </div>

        <form method="POST">

            <!-- CLIENTE -->
            <div class="mb-3">

                <label class="form-label">

                    Cliente

                </label>

                <select class="form-select" name="cliente_id" required>

                    <?php while ($cliente = mysqli_fetch_assoc($resultado_clientes)) { ?>

                        <option value="<?= $cliente['id']; ?>" <?= $cliente_selecionado == $cliente['id']
                              ? 'selected'
                              : ''
                              ?>>
                            <?= $cliente['nome']; ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <!-- SERVIÇO -->
            <div class="mb-3">

                <label class="form-label">

                    Serviço

                </label>

                <select class="form-select" name="servico_id" required>

                    <?php while ($servico = mysqli_fetch_assoc($resultado_servicos)) { ?>

                        <option value="<?= $servico['id']; ?>" <?= $servico_selecionado == $servico['id']
                              ? 'selected'
                              : ''
                              ?>>
                            <?= $servico['nome']; ?>
                        </option>

                    <?php } ?>

                </select>

            </div>

            <!-- DATA E HORA -->
            <div class="row">

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Data

                    </label>

                    <input type="date" name="data" class="form-control" required
                        value="<?= $data; ?>" onchange="this.form.submit()">

                </div>

                <div class="col-md-6 mb-3">

                    <label class="form-label">

                        Horário

                    </label>

                    <?php if ($numero_dia == 0) { ?>

                        <div class="alert alert-danger">

                            Não atendemos aos domingos.

                        </div>

                    <?php } else { ?>

                        <select name="horario" class="form-select" required>

                            <?php

                            for ($hora = $hora_inicio; $hora <= $hora_fim; $hora++) {

                                $hora_formatada = str_pad($hora, 2, '0', STR_PAD_LEFT);

                                $horario_cheio = $hora_formatada . ":00:00";

                                if (
                                    !in_array($horario_cheio, $horarios_ocupados)
                                    || $horario_cheio == $horario_selecionado
                                ) {

                                    ?>

                                    <option value="<?= $horario_cheio; ?>" <?= $horario_cheio == $horario_selecionado
                                          ? 'selected'
                                          : ''
                                          ?>>
                                        <?= $hora_formatada; ?>:00
                                    </option>

                                    <?php
                                }

                                if ($hora < $hora_fim) {

                                    $horario_meia = $hora_formatada . ":30:00";

                                    if (
                                        !in_array($horario_meia, $horarios_ocupados)
                                        || $horario_meia == $horario_selecionado
                                    ) {

                                        ?>

                                        <option value="<?= $horario_meia; ?>" <?= $horario_meia == $horario_selecionado
                                              ? 'selected'
                                              : ''
                                              ?>>
                                            <?= $hora_formatada; ?>:30
                                        </option>

                                        <?php
                                    }
                                }
                            }

                            ?>

                        </select>

                    <?php } ?>

                </div>

            </div>

            <!-- STATUS -->
            <div class="mb-3">

                <label class="form-label">

                    Status

                </label>

                <select name="status" class="form-select">

                    <option value="PENDENTE" <?= $status == 'PENDENTE' ? 'selected' : '' ?>>
                        Pendente
                    </option>

                    <option value="CONFIRMADO" <?= $status == 'CONFIRMADO' ? 'selected' : '' ?>>
                        Confirmado
                    </option>

                    <option value="FINALIZADO" <?= $status == 'FINALIZADO' ? 'selected' : '' ?>>
                        Finalizado
                    </option>

                    <option value="CANCELADO" <?= $status == 'CANCELADO' ? 'selected' : '' ?>>
                        Cancelado
                    </option>

                </select>

            </div>

            <!-- OBSERVAÇÕES -->
            <div class="mb-3">

                <label class="form-label">

                    Observações

                </label>

                <textarea class="form-control" name="observacoes" rows="3"><?= $observacoes; ?></textarea>

            </div>

            <button type="submit" name="editar" class="btn btn-dark w-100">
                Salvar Alterações
            </button>

        </form>

    </div>

</section>