<?php

require_once 'config.php';
require_once 'includes/header.php';

$sql = "
SELECT *
FROM servico
ORDER BY status ASC, nome ASC
";

$resultado = mysqli_query($conn, $sql);

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    <h1 class="h2">

        Serviços

    </h1>

    <a
        href="novo_servico.php"
        class="btn btn-primary d-flex align-items-center gap-2"
    >
        <i class="bi bi-plus-lg"></i>

        Novo Serviço
    </a>

</div>

<div class="row row-cols-1 row-cols-md-3 g-4">

<?php while($servico = mysqli_fetch_assoc($resultado)) { ?>

    <div class="col">

        <div class="card h-100 shadow-sm">

            <div class="card-body">

                <h5 class="card-title d-flex justify-content-between">

                    <?= $servico['nome'] ?>

                    <span class="text-primary fw-bold">

                        R$

                        <?= number_format(
                            $servico['preco'],
                            2,
                            ',',
                            '.'
                        ) ?>

                    </span>

                </h5>

                <p class="card-text text-muted">

                    <?= $servico['descricao'] ?>

                </p>

                <p class="mb-2 small">

                    <i class="bi bi-clock me-1"></i>

                    <?= $servico['duracao'] ?> min

                </p>

                <?php if($servico['status'] == 'ATIVO') { ?>

                    <span class="badge bg-success">

                        Ativo

                    </span>

                <?php } else { ?>

                    <span class="badge bg-danger">

                        Inativo

                    </span>

                <?php } ?>

            </div>

            <div class="card-footer bg-transparent border-top-0 pb-3 d-flex gap-2">

                <!-- EDITAR -->
                <a
                    href="editar_servico.php?id=<?= $servico['id'] ?>"
                    class="btn btn-sm btn-outline-secondary"
                >
                    <i class="bi bi-pencil"></i>
                </a>

            </div>

        </div>

    </div>

<?php } ?>

</div>

<?php require_once 'includes/footer.php'; ?>