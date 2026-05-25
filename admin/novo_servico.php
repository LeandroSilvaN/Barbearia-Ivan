<?php

require_once 'config.php';
require_once 'includes/header.php';

$nome = "";

$descricao = "";

$preco = "";

$duracao = "";

$status = "ATIVO";

if (isset($_POST['cadastrar_servico'])) {

    $nome = trim($_POST['nome']);

    $descricao = trim($_POST['descricao']);

    $preco = str_replace(',', '.', $_POST['preco']);

    $duracao = $_POST['duracao'];

    $status = $_POST['status'];

    $sql_verificar = "
    SELECT id
    FROM servico
    WHERE nome = '$nome'
    ";

    $resultado_verificar = mysqli_query($conn, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {

        echo "
        <div class='container mt-4'>

            <div class='alert alert-danger text-center'>

                Já existe um serviço com este nome.

            </div>

        </div>
        ";

    } else {

        $sql_insert = "
        INSERT INTO servico (

            nome,
            descricao,
            preco,
            duracao,
            status

        )
        VALUES (

            '$nome',
            '$descricao',
            '$preco',
            '$duracao',
            '$status'

        )
        ";

        $resultado_insert = mysqli_query($conn, $sql_insert);

        if ($resultado_insert) {

            echo "
            <script>

                alert('Serviço cadastrado com sucesso!');

                window.location.href = 'services.php';

            </script>
            ";

        } else {

            echo "
            <div class='container mt-4'>

                <div class='alert alert-danger text-center'>

                    Erro ao cadastrar serviço.

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

                Novo Serviço

            </h3>

        </div>

        <form method="POST">

            <!-- NOME -->
            <div class="mb-3">

                <label class="form-label">

                    Nome do Serviço

                </label>

                <input
                    type="text"
                    name="nome"
                    class="form-control"
                    required
                    value="<?= $nome ?>"
                >

            </div>

            <!-- DESCRIÇÃO -->
            <div class="mb-3">

                <label class="form-label">

                    Descrição

                </label>

                <textarea
                    name="descricao"
                    class="form-control"
                    rows="3"
                    required
                ><?= $descricao ?></textarea>

            </div>

            <!-- PREÇO -->
            <div class="mb-3">

                <label class="form-label">

                    Preço

                </label>

                <input
                    type="text"
                    name="preco"
                    class="form-control"
                    required
                    placeholder="Ex: 45.00"
                    value="<?= $preco ?>"
                >

            </div>

            <!-- DURAÇÃO -->
            <div class="mb-3">

                <label class="form-label">

                    Duração (em minutos)

                </label>

                <input
                    type="number"
                    name="duracao"
                    class="form-control"
                    required
                    min="5"
                    step="5"
                    value="<?= $duracao ?>"
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

            <!-- BOTÃO -->
            <button
                type="submit"
                name="cadastrar_servico"
                class="btn btn-dark w-100"
            >
                Cadastrar Serviço
            </button>

        </form>

    </div>

</section>

<?php require_once 'includes/footer.php'; ?>