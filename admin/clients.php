<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Clientes</h1>
    <button class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-person-plus"></i> Novo Cliente
    </button>
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
                    <tr>
                        <td>Gabriel Lima</td>
                        <td>(11) 99999-9999</td>
                        <td>01/03/2026</td>
                        <td>R$ 450,00</td>
                        <td>
                            <button class="btn btn-sm btn-light border"><i class="bi bi-eye"></i></button>
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
