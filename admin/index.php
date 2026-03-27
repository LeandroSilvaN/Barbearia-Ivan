<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card text-white bg-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Agendamentos Hoje</h5>
                <p class="card-text fs-2 fw-bold">12</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Clientes Novos (Mês)</h5>
                <p class="card-text fs-2 fw-bold">45</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Faturamento (Dia)</h5>
                <p class="card-text fs-2 fw-bold">R$ 850,00</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Cancelamentos</h5>
                <p class="card-text fs-2 fw-bold">2</p>
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
                    <th>Hora</th>
                    <th>Cliente</th>
                    <th>Serviço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>09:00</td>
                    <td>Gabriel Lima</td>
                    <td>Corte de Cabelo</td>
                    <td><span class="badge bg-success">Confirmado</span></td>
                    <td><button class="btn btn-sm btn-outline-primary shadow-sm px-3">Ver</button></td>
                </tr>
                <tr>
                    <td>10:00</td>
                    <td>Ricardo Souza</td>
                    <td>Barba Completa</td>
                    <td><span class="badge bg-warning">Pendente</span></td>
                    <td><button class="btn btn-sm btn-outline-primary shadow-sm px-3">Ver</button></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
