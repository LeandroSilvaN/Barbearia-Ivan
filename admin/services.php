<?php
require_once 'config.php';
require_once 'includes/header.php';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Serviços</h1>
    <button class="btn btn-primary d-flex align-items-center gap-2">
        <i class="bi bi-plus-lg"></i> Novo Serviço
    </button>
</div>

<div class="row row-cols-1 row-cols-md-3 g-4">
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title d-flex justify-content-between">
                    Corte de Cabelo
                    <span class="text-primary fw-bold">R$ 45,00</span>
                </h5>
                <p class="card-text text-muted">Corte masculino completo com acabamento.</p>
                <p class="mb-0 small"><i class="bi bi-clock me-1"></i> 30 min</p>
            </div>
            <div class="card-footer bg-transparent border-top-0 pb-3">
                <button class="btn btn-sm btn-outline-secondary">Editar</button>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card h-100 shadow-sm">
            <div class="card-body">
                <h5 class="card-title d-flex justify-content-between">
                    Barba
                    <span class="text-primary fw-bold">R$ 30,00</span>
                </h5>
                <p class="card-text text-muted">Desenho, hidratação e toalha quente.</p>
                <p class="mb-0 small"><i class="bi bi-clock me-1"></i> 20 min</p>
            </div>
            <div class="card-footer bg-transparent border-top-0 pb-3">
                <button class="btn btn-sm btn-outline-secondary">Editar</button>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
