<?php

require_once 'config.php';
require_once 'includes/header.php';

$nome = "";

$email = "";

$telefone = "";

$status = "ATIVO";

if (isset($_POST['cadastrar_cliente'])) {

    $nome = trim($_POST['nome']);

    $email = trim($_POST['email']);

    $telefone = trim($_POST['telefone']);

    $senha = $_POST['senha'];

    $status = $_POST['status'];

    $senha_criptografada = password_hash($senha, PASSWORD_DEFAULT);

    $sql_verificar = "
    SELECT id
    FROM usuarios
    WHERE email = '$email'
    ";

    $resultado_verificar = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {

        echo "
        <div class='container mt-4'>

            <div class='alert alert-danger text-center'>

                Já existe um cliente com este e-mail.

            </div>

        </div>
        ";

    } else {

        $sql_insert = "
        INSERT INTO usuarios (

            nome,
            email,
            telefone,
            senha,
            role,
            status

        )
        VALUES (

            '$nome',
            '$email',
            '$telefone',
            '$senha_criptografada',
            'USER',
            '$status'

        )
        ";

        $resultado_insert = mysqli_query($conn, $sql_insert);

        if ($resultado_insert) {

            echo "
            <script>

                alert('Cliente cadastrado com sucesso!');

                window.location.href = 'clients.php';

            </script>
            ";

        } else {

            echo "
            <div class='container mt-4'>

                <div class='alert alert-danger text-center'>

                    Erro ao cadastrar cliente.

                </div>

            </div>
            ";

        }

    }

}

?>

<section class="container my-5">

    <div
        class="card shadow p-4 mx-auto"
        style="max-width: 600px; border-radius: 15px;"
    >

        <div class="text-center mb-4">

            <h3 class="fw-bold">

                Novo Cliente

            </h3>

        </div>

        <form method="POST">

            <!-- NOME -->
            <div class="mb-3">

                <label class="form-label">

                    Nome

                </label>

                <input
                    type="text"
                    name="nome"
                    class="form-control"
                    required
                    value="<?= $nome ?>"
                >

            </div>

            <!-- EMAIL -->
            <div class="mb-3">

                <label class="form-label">

                    E-mail

                </label>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    required
                    value="<?= $email ?>"
                >

            </div>

            <!-- TELEFONE -->
            <div class="mb-3">

                <label class="form-label">

                    Telefone

                </label>

                <input
                    type="text"
                    name="telefone"
                    class="form-control"
                    required
                    value="<?= $telefone ?>"
                >

            </div>

            <!-- SENHA -->
            <div class="mb-3">

                <label class="form-label">

                    Senha

                </label>

                <input
                    type="password"
                    name="senha"
                    class="form-control"
                    required
                >

            </div>

            <!-- STATUS -->
            <div class="mb-4">

                <label class="form-label">

                    Status

                </label>

                <select
                    name="status"
                    class="form-select"
                >

                    <option
                        value="ATIVO"
                        <?= $status == 'ATIVO' ? 'selected' : '' ?>
                    >
                        Ativo
                    </option>

                    <option
                        value="INATIVO"
                        <?= $status == 'INATIVO' ? 'selected' : '' ?>
                    >
                        Inativo
                    </option>

                </select>

            </div>

            <!-- BOTÃO -->
            <button
                type="submit"
                name="cadastrar_cliente"
                class="btn btn-dark w-100"
            >
                Cadastrar Cliente
            </button>

        </form>

    </div>

</section>

<?php require_once 'includes/footer.php'; ?>