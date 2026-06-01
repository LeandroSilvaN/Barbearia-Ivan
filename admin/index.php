<?php
require_once 'config.php';
require_once 'includes/header.php';

$dataHoje = date('Y-m-d');
$mesAtual = date('m');
$anoAtual = date('Y');

/* Agendamentos hoje */
$sql_agendamentos = "
SELECT COUNT(*) AS total
FROM agendamento
WHERE data = '$dataHoje'
";

$resultado = mysqli_query($conn, $sql_agendamentos);
$agendamentosHoje = mysqli_fetch_assoc($resultado)['total'];


/* Clientes novos do mês */
$sql_clientes = "
SELECT COUNT(*) AS total
FROM usuarios
WHERE MONTH(created_at) = '$mesAtual'
AND YEAR(created_at) = '$anoAtual'
AND role != 'ADMIN'
AND status = 'ATIVO'
";

$resultado = mysqli_query($conn, $sql_clientes);
$clientesMes = mysqli_fetch_assoc($resultado)['total'];


/* Faturamento do dia */
$sql_faturamento = "
SELECT SUM(preco) AS total
FROM agendamento
WHERE data='$dataHoje'
AND status='FINALIZADO'
";

$resultado = mysqli_query($conn, $sql_faturamento);
$faturamento = mysqli_fetch_assoc($resultado);

$totalFaturamento = $faturamento['total'] ?? 0;


/* Cancelamentos */
$sql_cancelados = "
SELECT COUNT(*) AS total
FROM agendamento
WHERE status='CANCELADO'
AND data='$dataHoje'
";

$resultado = mysqli_query($conn, $sql_cancelados);
$cancelamentos = mysqli_fetch_assoc($resultado)['total'];


/* Próximos atendimentos */
$sql_proximos = "
SELECT
a.data,
a.horario,
u.nome AS cliente,
s.nome AS servico,
a.status,
a.id

FROM agendamento a

INNER JOIN usuarios u
ON a.cliente_id = u.id

INNER JOIN servico s
ON a.servico_id = s.id

WHERE (
a.data > CURDATE()
OR (
a.data = CURDATE()
AND a.horario >= CURTIME()
)
)

ORDER BY a.data, a.horario
LIMIT 5
";

$proximos = mysqli_query($conn, $sql_proximos);
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Agendamentos Hoje</h5>
                <p class="card-text fs-2 fw-bold"><?= $agendamentosHoje ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Clientes Novos (Mês)</h5>
                <p class="card-text fs-2 fw-bold"><?= $clientesMes ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Faturamento (Dia)</h5>
                <p class="card-text fs-2 fw-bold">
                    R$ <?= number_format($totalFaturamento, 2, ",", ".") ?>
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Cancelamentos</h5>
                <p class="card-text fs-2 fw-bold"><?= $cancelamentos ?></p>
            </div>
        </div>
    </div>
</div>

<div class="mt-4">
    <h4>Próximos Atendimentos</h4>
    <div class="table-responsive">
        <table class="table table-striped table-sm align-middle">
            <thead>
                <tr>

                    <th>Dia</th>
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Status</th>
                </tr>

            </thead>
            <tbody>

                <?php while ($linha = mysqli_fetch_assoc($proximos)): ?>
                    <?php

                    $dataAtendimento = $linha['data'];

                    if ($dataAtendimento == date('Y-m-d')) {
                        $diaExibicao = "Hoje";
                    } elseif ($dataAtendimento == date('Y-m-d', strtotime('+1 day'))) {
                        $diaExibicao = "Amanhã";
                    } else {
                        $diaExibicao = date(
                            'd/m',
                            strtotime($dataAtendimento)
                        );
                    }

                    ?>
                    <tr>

<td><?= $diaExibicao ?></td>

<td><?= substr($linha['horario'],0,5) ?></td>

<td><?= $linha['cliente'] ?></td>

<td><?= $linha['servico'] ?></td>

<td>

<?php
if($linha['status']=="CONFIRMADO"){
    echo '<span class="badge bg-success">Confirmado</span>';
}
elseif($linha['status']=="PENDENTE"){
    echo '<span class="badge bg-warning">Pendente</span>';
}
elseif($linha['status']=="CANCELADO"){
    echo '<span class="badge bg-danger">Cancelado</span>';
}
else{
    echo '<span class="badge bg-primary">'.$linha['status'].'</span>';
}
?>

</td>

</tr>

                <?php endwhile; ?>

            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>