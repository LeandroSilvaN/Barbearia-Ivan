<?php

require_once 'config.php';
require_once 'includes/header.php';

$id = $_GET['id'];

$sql = "
SELECT *
FROM usuarios
WHERE id = $id
";

$resultado = mysqli_query($conn, $sql);

$cliente = mysqli_fetch_assoc($resultado);

$nome = $cliente['nome'];

$email = $cliente['email'];

$telefone = $cliente['telefone'];

$status = $cliente['status'];

if (isset($_POST['editar_cliente'])) {

    $nome = trim($_POST['nome']);

    $email = trim($_POST['email']);

    $telefone = trim($_POST['telefone']);

    $novo_status = $_POST['status'];

    $sql_verificar = "
    SELECT id
    FROM usuarios
    WHERE email = '$email'
    AND id != $id
    ";

    $resultado_verificar = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {

        echo "
        <div class='alert alert-danger text-center'>
            Já existe outro usuário com este e-mail.
        </div>
        ";

    } else {

        $sql_update = "
UPDATE usuarios SET

    nome = '$nome',
    email = '$email',
    telefone = '$telefone',
    status = '$novo_status'

WHERE id = $id
";

$resultado_update = mysqli_query($conn, $sql_update);

/*
CANCELAR AGENDAMENTOS FUTUROS
*/

if (
    $status == 'ATIVO'
    && $novo_status == 'INATIVO'
) {

    $sql_cancelar = "
    UPDATE agendamento
    SET status = 'CANCELADO'
    WHERE

        cliente_id = $id

        AND status IN (
            'PENDENTE',
            'CONFIRMADO'
        )

        AND CONCAT(data, ' ', horario) >= NOW()
    ";

    mysqli_query($conn, $sql_cancelar);

}

/*
RESTAURAR AGENDAMENTOS
*/

if (
    $status == 'INATIVO'
    && $novo_status == 'ATIVO'
) {

    $sql_restaurar = "
    UPDATE agendamento
    SET status = 'PENDENTE'
    WHERE

        cliente_id = $id

        AND status = 'CANCELADO'

        AND CONCAT(data, ' ', horario) >= NOW()
    ";

    mysqli_query($conn, $sql_restaurar);

}

        if ($resultado_update) {

            echo "
            <script>

                alert('Cliente atualizado com sucesso!');

                window.location.href = 'clients.php';

            </script>
            ";

        } else {

            echo "
            <div class='alert alert-danger text-center'>
                Erro ao atualizar cliente.
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

                Editar Cliente

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
                        <?= $status == 'ATIVO'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Ativo
                    </option>

                    <option
                        value="INATIVO"
                        <?= $status == 'INATIVO'
                            ? 'selected'
                            : ''
                        ?>
                    >
                        Inativo
                    </option>

                </select>

            </div>

            <button
                type="submit"
                name="editar_cliente"
                class="btn btn-dark w-100"
            >
                Salvar Alterações
            </button>

        </form>

    </div>

</section>

<?php require_once 'includes/footer.php'; ?>