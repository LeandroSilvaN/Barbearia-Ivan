<?php

session_start();

include("../config/conection.php");

if (!isset($_SESSION['id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_SESSION['id'];

$sql = "SELECT * FROM usuarios WHERE id = $id";
$resultado = mysqli_query($conn, $sql);

$usuario = mysqli_fetch_assoc($resultado);

if (isset($_POST['salvar'])) {

    $nome = $_POST['nome'];
    $email = $_POST['email'];

    $sql_update = "
    
    UPDATE usuarios
    SET
    
    nome='$nome',
    email='$email'
    
    WHERE id='$id'
    
    ";

    $resultado_update = mysqli_query($conn, $sql_update);

    if ($resultado_update) {

        $_SESSION['nome'] = $nome;
        $_SESSION['email'] = $email;

        echo "
        <script>

        alert('Perfil atualizado com sucesso');

        window.location='perfil.php';

        </script>
        ";
    }
}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>

        Editar Perfil

    </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {

            background: #f5f5f5;

        }

        .card-editar {

            max-width: 700px;

            margin: auto;

            border-radius: 15px;

            padding: 30px;

            box-shadow: 0 0 20px rgba(0, 0, 0, .1);

            background: white;

        }
    </style>

</head>

<body>

    <div class="container my-5">

        <div class="card-editar">

            <h2 class="text-center mb-4">

                Editar Perfil

            </h2>

           <form method="POST">

<div class="mb-3">

<label class="form-label">

Nome

</label>

<input
type="text"
name="nome"
class="form-control"
required
value="<?php echo $usuario['nome']; ?>">

</div>


<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
name="email"
class="form-control"
required
value="<?php echo $usuario['email']; ?>">

</div>


<div class="mb-3">

<label class="form-label">

Telefone

</label>

<input
type="text"
name="telefone"
class="form-control"
required
value="<?php echo $usuario['telefone']; ?>">

</div>


<hr>

<h5>

Alterar senha

</h5>

<small class="text-muted">

Deixe em branco para manter a senha atual

</small>

<div class="mb-3 mt-3">

<label class="form-label">

Nova senha

</label>

<input
type="password"
name="senha"
class="form-control">

</div>


<div class="d-flex gap-2">

<button
type="submit"
name="salvar"
class="btn btn-dark">

Salvar

</button>

<a
href="perfil.php"
class="btn btn-secondary">

Cancelar

</a>

</div>

</form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>