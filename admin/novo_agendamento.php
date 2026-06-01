<?php 
require_once 'config.php';
require_once 'includes/header.php';
$sql_servicos = "SELECT * FROM servico WHERE status = 'ATIVO'";
$resultado_servicos = mysqli_query($conn, $sql_servicos);
$sql_clientes = "SELECT * FROM usuarios WHERE role = 'USER' AND status = 'ATIVO'";
$resultado_clientes = mysqli_query($conn, $sql_clientes);
$data = "";
$cliente_selecionado = "";
$servico_selecionado = "";
$horarios_ocupados = [];
$numero_dia = -1;
$hora_inicio = 9;
$hora_fim = 19;
if (isset($_POST['cliente_id'])) {
    $cliente_selecionado = $_POST['cliente_id'];
}
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
    $sql_data = " SELECT ag.horario, ser.duracao FROM agendamento ag INNER JOIN servico ser ON ag.servico_id = ser.id WHERE ag.data = '$data' AND ag.status IN ( 'CONFIRMADO', 'PENDENTE' ) ";
    $resultado_data = mysqli_query($conn, $sql_data);
    while ($agendamento = mysqli_fetch_assoc($resultado_data)) {
        $horario_base = $agendamento['horario'];
        $duracao = $agendamento['duracao'];
        $blocos = ceil($duracao / 30);
        for ($i = 0; $i < $blocos; $i++) {
            $horario_bloqueado = date('H:i:s', strtotime("+" . ($i * 30) . " minutes", strtotime($horario_base)));
            $horarios_ocupados[] = $horario_bloqueado;
        }
    }
    $resultado_data = mysqli_query($conn, $sql_data);
    while ($agendamento = mysqli_fetch_assoc($resultado_data)) {
        $horarios_ocupados[] = $agendamento['horario'];
    }
}
if (isset($_POST['confirmar_agendamento'])) {
    $cliente_id = $_POST['cliente_id'];
    $servico_id = $_POST['servico_id'];
    $data_agendamento = $_POST['data'];
    $horario = $_POST['horario'];

    $observacoes = $_POST['observacoes'];
    $sql_preco = " SELECT preco FROM servico WHERE id = $servico_id ";
    $resultado_preco = mysqli_query($conn, $sql_preco);
    $servico = mysqli_fetch_assoc($resultado_preco);
    $preco = $servico['preco'];
    $sql_insert = " INSERT INTO agendamento ( data, horario, observacoes, status, cliente_id, servico_id, preco ) VALUES ( '$data_agendamento', '$horario', '$observacoes', 'CONFIRMADO', '$cliente_id', '$servico_id', '$preco' ) ";
    $resultado_insert = mysqli_query($conn, $sql_insert);
    if ($resultado_insert) {
        echo " <script> alert('Agendamento realizado com sucesso!'); window.location.href = 'novo_agendamento.php'; </script> ";
    } else {
        echo " <div class='alert alert-danger text-center'> Erro ao agendar. </div> ";
    }
} ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Agendamento</title>
</head>

<body>
    <section class="container my-5">
        <div class="card shadow p-4 mx-auto" style="max-width: 600px; border-radius: 15px;">
            <div class="text-center mb-4">
                <h3 class="fw-bold">Agendar Horário</h3>
            </div>
            <form method="POST"> <!-- Serviço -->
                <div class="mb-3"> <label for="form-label"> Cliente </label> <select class="form-select"
                        name="cliente_id" required>
                        <option selected disabled> Selecione um cliente </option>
                        <?php while ($cliente = mysqli_fetch_assoc($resultado_clientes)) { ?>
                            <option value="<?php echo $cliente['id']; ?>" <?php if ($cliente_selecionado == $cliente['id']) {
                                   echo "selected";
                               } ?>> <?php echo $cliente['nome']; ?> </option> <?php } ?>
                    </select> </div>
                <div class="mb-3"> <label class="form-label">Serviço</label> <select class="form-select"
                        name="servico_id" required>
                        <option selected disabled> Selecione um serviço </option>
                        <?php while ($servico = mysqli_fetch_assoc($resultado_servicos)) { ?>
                            <option value="<?php echo $servico['id']; ?>" <?php if ($servico_selecionado == $servico['id']) {
                                   echo "selected";
                               } ?>> <?php echo $servico['nome']; ?> </option> <?php } ?>
                    </select> </div> <!-- Data e Hora -->
                <div class="row">
                    <div class="col-md-6 mb-3"> <label class="form-label">Data</label> <input type="date" name="data"
                            class="form-control" required min="<?php echo date('Y-m-d'); ?>"
                            onchange="this.form.submit()" value="<?php echo $data; ?>"> </div>
                    <div class="col-md-6 mb-3"> <label class="form-label">Horário</label>
                        <?php if (count($horarios_ocupados) < 21) { ?>     <?php if ($numero_dia == 0) { ?>
                                <div class="alert alert-danger"> Não atendemos aos domingos. </div> <?php } else { ?> <select
                                    name="horario" class="form-select" required>
                                    <option selected disabled> Selecione um horário </option>
                                    <?php for ($hora = $hora_inicio; $hora <= $hora_fim; $hora++) {
                                        $hora_formatada = str_pad($hora, 2, '0', STR_PAD_LEFT);
                                        $horario_cheio = $hora_formatada . ":00:00";
                                        if (!in_array($horario_cheio, $horarios_ocupados)) { ?>
                                            <option value="<?php echo $horario_cheio; ?>"> <?php echo $hora_formatada; ?>:00 </option>
                                        <?php }
                                        if ($hora < $hora_fim) {
                                            $horario_meia = $hora_formatada . ":30:00";
                                            if (!in_array($horario_meia, $horarios_ocupados)) { ?>
                                                <option value="<?php echo $horario_meia; ?>"> <?php echo $hora_formatada; ?>:30 </option>
                                            <?php }
                                        }
                                    } ?>
                                </select> <?php } ?> <?php } else { ?>
                            <div class="alert alert-danger"> Todos os horários estão ocupados. </div> <?php } ?>
                    </div>
                </div> <!-- Observação -->
                <div class="mb-3"> <label class="form-label">Observações (opcional)</label> <textarea
                        class="form-control" name="observacoes" rows="3"
                        placeholder="Alguma preferência ou pedido especial?"></textarea> </div> <button type="submit"
                    name="confirmar_agendamento" class="btn btn-dark w-100"> Confirmar Agendamento </button>
            </form>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", function () {

    let campoData = document.querySelector(
        'input[name="data"]'
    );

    let selectHorario = document.querySelector(
        'select[name="horario"]'
    );

    if (!campoData || !selectHorario) return;

    let hoje = new Date();

    let ano = hoje.getFullYear();

    let mes = String(
        hoje.getMonth() + 1
    ).padStart(2, '0');

    let dia = String(
        hoje.getDate()
    ).padStart(2, '0');

    let dataAtual =
        `${ano}-${mes}-${dia}`;

    if (campoData.value === dataAtual) {

        let horaAtual =
            hoje.getHours();

        let minutoAtual =
            hoje.getMinutes();

        Array.from(
            selectHorario.options
        ).forEach(function(opcao){

            if (!opcao.value)
                return;

            let partes =
                opcao.value.split(":");

            let hora =
                parseInt(partes[0]);

            let minuto =
                parseInt(partes[1]);

            let horarioJaPassou = false;

            if (
                hora < horaAtual
            ) {
                horarioJaPassou = true;
            }

            if (
                hora === horaAtual
                &&
                minuto <= minutoAtual
            ) {
                horarioJaPassou = true;
            }

            if (
                horarioJaPassou
            ) {
                opcao.remove();
            }

        });

    }

});

    </script>
</body>

</html>