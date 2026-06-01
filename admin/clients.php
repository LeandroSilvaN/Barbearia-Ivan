<?php

require_once 'config.php';
require_once 'includes/header.php';

$sql = "
SELECT

    u.id,
    u.nome,
    u.telefone,

    MAX(
    CASE
        WHEN ag.status = 'FINALIZADO'
        THEN ag.data
        ELSE NULL
    END
) AS ultima_visita,

    SUM(
        CASE
            WHEN ag.status = 'FINALIZADO'
            THEN ag.preco
            ELSE 0
        END
    ) AS total_gasto

FROM usuarios u

LEFT JOIN agendamento ag
    ON ag.cliente_id = u.id

LEFT JOIN servico ser
    ON ag.servico_id = ser.id

WHERE
    u.role = 'USER'
    AND u.status = 'ATIVO'

GROUP BY
    u.id,
    u.nome,
    u.telefone

ORDER BY u.nome ASC
";

$resultado = mysqli_query($conn, $sql);

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Clientes</h1>
    <a href="novo_cliente.php" class="bi-person-plus btn btn-primary d-flex align-items-center gap-2">Novo
        Cliente</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Última Visita</th>
                        <th>Total Gasto</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>

                    <?php while ($cliente = mysqli_fetch_assoc($resultado)) { ?>

                        <tr>

                            <td>
                                <?= $cliente['nome'] ?>
                            </td>

                            <td>
    <?php

    $telefone = $cliente['telefone'];

    $telefone = preg_replace(
        "/(\d{2})(\d{5})(\d{4})/",
        "($1) $2-$3",
        $telefone
    );

    echo $telefone;

    ?>
</td>

                            <td>

                                <?php

                                if ($cliente['ultima_visita']) {

                                    echo date(
                                        'd/m/Y',
                                        strtotime($cliente['ultima_visita'])
                                    );

                                } else {

                                    echo '-';

                                }

                                ?>

                            </td>

                            <td>

                                R$

                                <?= number_format(
                                    $cliente['total_gasto'] ?? 0,
                                    2,
                                    ',',
                                    '.'
                                ) ?>

                            </td>

                            <td>

                                <!-- HISTÓRICO -->
                                <a href="historico_cliente.php?id=<?= $cliente['id'] ?>"
                                    class="btn btn-sm btn-light border">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <!-- EDITAR -->
                                <a href="editar_cliente.php?id=<?= $cliente['id'] ?>" class="btn btn-sm btn-light border">
                                    <i class="bi bi-pencil"></i>
                                </a>

                            </td>

                        </tr>

                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>