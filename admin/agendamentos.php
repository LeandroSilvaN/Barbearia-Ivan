<?php
require_once 'config.php';
require_once 'includes/header.php';

$sql_update = "
UPDATE agendamento
SET status = 'FINALIZADO'
WHERE
    status = 'CONFIRMADO'
    AND CONCAT(data, ' ', horario) < NOW()
";

mysqli_query($conn, $sql_update);

$sql = "
SELECT
    ag.id,
    ag.data,
    ag.horario,
    ag.status,
    ag.observacoes,

    cli.nome AS cliente,

    ser.nome AS servico,
    ag.preco

FROM agendamento ag

INNER JOIN usuarios cli
    ON ag.cliente_id = cli.id

INNER JOIN servico ser
    ON ag.servico_id = ser.id

WHERE

    ag.status = 'PENDENTE'

    OR

    (
        ag.status != 'PENDENTE'
        AND ag.data >= CURDATE() - INTERVAL 1 DAY
    )

ORDER BY
    ag.status = 'FINALIZADO',
    ag.data ASC,
    ag.horario ASC
";

$resultado = mysqli_query($conn, $sql);



?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Agendamentos</h1>
    <a href="novo_agendamento.php" class="bi-plus-circle btn btn-primary d-flex align-items-center gap-2">Novo
        Agendamento</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Data/Hora</th>
                        <th>Cliente</th>
                        <th>Serviço</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>

                <tbody>

                    <?php while ($agendamento = mysqli_fetch_assoc($resultado)) { ?>

                        <tr>

                            <td>
                                <?= date('d/m/Y', strtotime($agendamento['data'])) ?>
                                às
                                <?= substr($agendamento['horario'], 0, 5) ?>
                            </td>

                            <td>
                                <?= $agendamento['cliente'] ?>
                            </td>

                            <td>
                                <?= $agendamento['servico'] ?>
                            </td>

                            <td>

                                <?php if ($agendamento['status'] == 'PENDENTE') { ?>
                                    <span class="badge bg-warning">
                                        Pendente
                                    </span>
                                <?php } ?>

                                <?php if ($agendamento['status'] == 'CONFIRMADO') { ?>
                                    <span class="badge bg-success">
                                        Confirmado
                                    </span>
                                <?php } ?>

                                <?php if ($agendamento['status'] == 'FINALIZADO') { ?>
                                    <span class="badge bg-primary">
                                        Finalizado
                                    </span>
                                <?php } ?>

                                <?php if ($agendamento['status'] == 'CANCELADO') { ?>
                                    <span class="badge bg-danger">
                                        Cancelado
                                    </span>
                                <?php } ?>

                            </td>

                            <td>
                                R$ <?= number_format($agendamento['preco'], 2, ',', '.') ?>
                            </td>

                            <td>
                                <button type="button" class="btn btn-sm btn-light border text-danger"
                                    data-bs-toggle="modal" data-bs-target="#modalObservacao<?= $agendamento['id'] ?>">
                                    <i class="bi bi-info-circle"></i>
                                </button>

                                <a class="btn btn-sm btn-light border text-danger"
                                    href="editar_agendamento.php?id=<?= $agendamento['id'] ?>"
                                    class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <a class="btn btn-sm btn-light border text-danger"
                                    href="excluir_agendamento.php?id=<?= $agendamento['id'] ?>"
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Deseja excluir este agendamento?')">
                                    <i class="bi bi-trash"></i>
                                </a>

                            </td>

                        </tr>
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

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>