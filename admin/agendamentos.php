<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Agendamentos</h1>
    <button class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-circle"></i> Novo Agendamento
    </button>
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
                        <th>Barbeiro</th>
                        <th>Status</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>05/03/2026 - 09:00</td>
                        <td>Gabriel Lima</td>
                        <td>Corte + Barba</td>
                        <td>Marcos</td>
                        <td><span class="badge bg-success">Confirmado</span></td>
                        <td>R$ 75,00</td>
                        <td>
                            <button class="btn btn-sm btn-light border"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-light border text-danger"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>