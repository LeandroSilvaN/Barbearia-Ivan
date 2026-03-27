<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Barbearia</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    :root {
        --sidebar-width: 250px;
    }

    body {
        background-color: #f8f9fa;
    }

    #sidebar {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        background: #212529;
        color: #fff;
    }

    #content {
        margin-left: var(--sidebar-width);
        padding: 20px;
    }

    .nav-link {
        color: rgba(255, 255, 255, .75);
    }

    .nav-link:hover,
    .nav-link.active {
        color: #fff;
        background: rgba(255, 255, 255, .1);
    }
    </style>
</head>

<body>
    <div id="sidebar" class="d-flex flex-column p-3">
        <a href="index.php" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <i class="bi bi-scissors me-2 fs-4"></i>
            <span class="fs-4 fw-bold">BarberAdmin</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="index.php" class="nav-link" id="nav-home">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="agendamentos.php" class="nav-link" id="nav-appointments">
                    <i class="bi bi-calendar-event me-2"></i> Agendamentos
                </a>
            </li>
            <li>
                <a href="clients.php" class="nav-link" id="nav-clients">
                    <i class="bi bi-people me-2"></i> Clientes
                </a>
            </li>
            <li>
                <a href="services.php" class="nav-link" id="nav-services">
                    <i class="bi bi-list-stars me-2"></i> Serviços
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><?php echo htmlspecialchars($_SESSION['nome']); ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><span class="dropdown-item disabled"><?php echo htmlspecialchars($_SESSION['email']); ?></span></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="../page/auth/logout.php">Sair</a></li>
            </ul>
        </div>
    </div>
    <div id="content">