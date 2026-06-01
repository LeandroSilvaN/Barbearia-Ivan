<?php

session_start();

if (!isset($_SESSION['nome'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once("../config/conection.php");

$id = $_SESSION['id'];

$sql = "SELECT * FROM usuarios WHERE id='$id'";

$resultado = mysqli_query($conn, $sql);

$usuario = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Perfil | Barbearia Ivan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap');

        body {
            font-family: "Poppins";
            background-color: #f8f9fa;
        }

        .perfil-card {

            background: white;

            border-radius: 15px;

            padding: 30px;

            box-shadow: 0px 5px 20px rgba(0, 0, 0, .1);

        }

        .foto-perfil {

            width: 130px;
            height: 130px;

            border-radius: 50%;

            object-fit: cover;

            border: 4px solid #212529;
        }

        .info-titulo {

            font-weight: 600;

            color: #555;
        }
    </style>

</head>

<body>



    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">

            <a class="navbar-brand" href="../../index.php">
                <strong>Barbearia Ivan</strong>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">

                <span class="navbar-toggler-icon">

                </span>

            </button>

            <div class="collapse navbar-collapse justify-content-end" id="menu">

                <ul class="navbar-nav">

                    <div class="d-flex justify-content-center justify-content-lg-end mt-3 mt-lg-0 ms-lg-3">

                        <div class="d-flex gap-2 me-5">

                            <div class="dropdown">

                                <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">

                                    Olá,
                                    <?php echo htmlspecialchars($_SESSION['nome']); ?>

                                </button>

                                <ul class="dropdown-menu dropdown-menu-end">

                                    <li>

                                        <span class="dropdown-item disabled">

                                            <?php echo htmlspecialchars($_SESSION['email']); ?>

                                        </span>

                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="perfil.php">

                                            Perfil

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="meus_agendamentos.php">

                                            Meus Agendamentos

                                        </a>

                                    </li>

                                    <li>

                                        <a class="dropdown-item" href="../auth/logout.php">

                                            Sair

                                        </a>

                                    </li>

                                </ul>

                            </div>

                        </div>

                    </div>

                    <li class="nav-item">

                        <a class="nav-link" href="../../index.php">

                            Home

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../servicos.php">

                            Serviços

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../produtos.php">

                            Produtos

                        </a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link" href="../sobre.php">

                            Sobre

                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>

    <div class="container my-5">

        <div class="perfil-card mx-auto" style="max-width:700px;">

            <div class="text-center">

                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" class="foto-perfil">

                <h2 class="mt-3">

                    <?php echo htmlspecialchars($_SESSION['nome']); ?>

                </h2>

                <p class="text-muted">

                    Cliente Barbearia Ivan

                </p>

            </div>

            <hr>

            <div class="row mt-4">

                <div class="col-md-6 mb-3">

                    <p class="info-titulo">
                        Nome:
                    </p>

                    <p>
                        <?php echo htmlspecialchars($_SESSION['nome']); ?>
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <p class="info-titulo">
                        Email:
                    </p>

                    <p>
                        <?php echo htmlspecialchars($_SESSION['email']); ?>
                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <p class="info-titulo">
                        Telefone:
                    </p>

                    <p>

                        <?php

                        if (!empty($usuario['telefone'])) {

                            $telefone = preg_replace(
                                "/(\d{2})(\d{5})(\d{4})/",
                                "($1) $2-$3",
                                $usuario['telefone']
                            );

                            echo htmlspecialchars($telefone);

                        } else {

                            echo "Não informado";

                        }

                        ?>

                    </p>

                </div>

                <div class="col-md-6 mb-3">

                    <p class="info-titulo">
                        ID Usuário:
                    </p>

                    <p>
                        #<?php echo $_SESSION['id']; ?>
                    </p>

                </div>

                <div class="d-flex justify-content-center gap-3 mt-4">

    <a href="meus_agendamentos.php" class="btn btn-primary">
        Meus Agendamentos
    </a>

    <a href="editar_perfil.php" class="btn btn-dark">
        Editar Perfil
    </a>

</div>

            </div>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>