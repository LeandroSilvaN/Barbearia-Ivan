<?php

session_start();

include("../config/conection.php");

if (!isset($_SESSION['id'])) {

    header("Location: ../auth/login.php");
    exit;

}

$id_usuario = $_SESSION['id'];
$id = $_GET['id'];


/* AGENDAMENTO */

$sql_agendamento = "

SELECT *
FROM agendamento
WHERE id = $id
AND cliente_id = $id_usuario

";

$resultado_agendamento = mysqli_query(
    $conn,
    $sql_agendamento
);

if(mysqli_num_rows($resultado_agendamento)==0){

    die("Agendamento não encontrado.");

}

$agendamento = mysqli_fetch_assoc(
    $resultado_agendamento
);


/* NÃO EDITA AGENDAMENTO PASSADO */

if(
    strtotime($agendamento['data'])
    <
    strtotime(date('Y-m-d'))
){

    die("Não é permitido editar agendamentos passados.");

}


/* NÃO EDITA FINALIZADO/CANCELADO */

if(

    $agendamento['status']=="FINALIZADO"
    ||
    $agendamento['status']=="CANCELADO"

){

    die("Este agendamento não pode ser editado.");

}


/* SERVIÇOS */

$sql_servicos="

SELECT *
FROM servico
WHERE status='ATIVO'

";

$resultado_servicos=mysqli_query(
$conn,
$sql_servicos
);


/* DADOS */

$data=$agendamento['data'];

$servico_selecionado=
$agendamento['servico_id'];

$horario_selecionado=
$agendamento['horario'];

$observacoes=
$agendamento['observacoes'];

$horarios_ocupados=[];


/* FUNÇÃO */

function buscarHorariosOcupados(
    $conn,
    $data,
    $id
){

$horarios=[];

$sql="

SELECT

ag.horario,
ser.duracao

FROM agendamento ag

INNER JOIN servico ser
ON ag.servico_id=ser.id

WHERE

ag.data='$data'

AND ag.status IN(
'PENDENTE',
'CONFIRMADO'
)

AND ag.id != $id

";

$resultado=mysqli_query(
$conn,
$sql
);

while(
$linha=
mysqli_fetch_assoc(
$resultado
)
){

$horario_base=
$linha['horario'];

$duracao=
$linha['duracao'];

$blocos=
ceil(
$duracao/30
);

for(
$i=0;
$i<$blocos;
$i++
){

$horario_bloqueado=
date(

'H:i:s',

strtotime(
"+" . ($i*30) . " minutes",
strtotime(
$horario_base
)

)

);

$horarios[]=
$horario_bloqueado;

}

}

return $horarios;

}


/* PRIMEIRA CARGA */

$horarios_ocupados=
buscarHorariosOcupados(
$conn,
$data,
$id
);


/* TROCOU DATA */

if(isset($_POST['data'])){

$data=
$_POST['data'];

$servico_selecionado=
$_POST['servico_id'];

$horario_selecionado=
$_POST['horario'] ?? '';

$observacoes=
$_POST['observacoes'];

$horarios_ocupados=
buscarHorariosOcupados(
$conn,
$data,
$id
);

}


/* REGRAS DIA */

$numero_dia=
date(
'w',
strtotime($data)
);

$hora_inicio=9;
$hora_fim=19;

if($numero_dia==6){

$hora_fim=14;

}

if($numero_dia==0){

$hora_inicio=0;
$hora_fim=0;

}


/* SALVAR */

if(isset($_POST['editar'])){

$servico_id=
$_POST['servico_id'];

$data_agendamento=
$_POST['data'];

$horario=
$_POST['horario'];

$observacoes=
$_POST['observacoes'];


if(

strtotime($data_agendamento)

<

strtotime(
date('Y-m-d')
)

){

echo "

<div class='alert alert-danger text-center'>

Não pode selecionar datas anteriores.

</div>

";

}else{

$sql_update="

UPDATE agendamento SET

servico_id='$servico_id',
data='$data_agendamento',
horario='$horario',
observacoes='$observacoes'

WHERE id='$id'

";

mysqli_query(
$conn,
$sql_update
);

echo "

<script>

alert(
'Agendamento atualizado com sucesso!'
);

window.location='meus_agendamentos.php';

</script>

";

}

}

?>

<!DOCTYPE html>

<html lang="pt-br">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width,initial-scale=1"
>

<title>

Editar Agendamento

</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet"
>

<style>

body{

background:#f8f9fa;

}

.card{

border-radius:15px;

}

</style>

</head>

<body>

<section class="container my-5">

<div
class="card shadow p-4 mx-auto"
style="max-width:600px"
>

<div class="text-center mb-4">

<h3 class="fw-bold">

Editar Agendamento

</h3>

</div>

<form method="POST">

<div class="mb-3">

<label>

Serviço

</label>

<select
name="servico_id"
class="form-select"
required
>

<?php while($servico=mysqli_fetch_assoc($resultado_servicos)){ ?>

<option
value="<?=$servico['id']?>"
<?=$servico['id']==$servico_selecionado ? 'selected' : ''?>
>

<?=$servico['nome']?>

</option>

<?php } ?>

</select>

</div>


<div class="row">

<div class="col-md-6 mb-3">

<label>

Data

</label>

<input
type="date"
name="data"
class="form-control"
value="<?=$data?>"
min="<?=date('Y-m-d')?>"
required
onchange="this.form.submit()"
>

</div>


<div class="col-md-6 mb-3">

<label>

Horário

</label>

<?php if(count($horarios_ocupados)>=21){ ?>

<div class="alert alert-danger">

Todos os horários estão ocupados.

</div>

<?php }elseif($numero_dia==0){ ?>

<div class="alert alert-danger">

Não atendemos aos domingos.

</div>

<?php }else{ ?>

<select
name="horario"
class="form-select"
required
>

<?php

for(
$hora=$hora_inicio;
$hora<=$hora_fim;
$hora++
){

$hora_formatada=
str_pad(
$hora,
2,
'0',
STR_PAD_LEFT
);

$horario_cheio=
$hora_formatada.":00:00";

if(

!in_array(
$horario_cheio,
$horarios_ocupados
)

||

$horario_cheio==$horario_selecionado

){

?>

<option
value="<?=$horario_cheio?>"
<?=$horario_cheio==$horario_selecionado ? 'selected' : ''?>
>

<?=$hora_formatada?>:00

</option>

<?php }

if($hora<$hora_fim){

$horario_meia=
$hora_formatada.":30:00";

if(

!in_array(
$horario_meia,
$horarios_ocupados
)

||

$horario_meia==$horario_selecionado

){

?>

<option
value="<?=$horario_meia?>"
<?=$horario_meia==$horario_selecionado ? 'selected' : ''?>
>

<?=$hora_formatada?>:30

</option>

<?php }}} ?>

</select>

<?php } ?>

</div>

</div>


<div class="mb-3">

<label>

Observações

</label>

<textarea
name="observacoes"
class="form-control"
rows="3"
><?=$observacoes?></textarea>

</div>

<div class="d-flex gap-2">

<?php if(
    $numero_dia != 0
    &&
    count($horarios_ocupados) < 21
){ ?>

<button
type="submit"
name="editar"
class="btn btn-dark w-100"
>

Salvar Alterações

</button>

<?php } ?>

<a
href="meus_agendamentos.php"
class="btn btn-secondary w-100
<?= ($numero_dia == 0 || count($horarios_ocupados) >= 21)
? 'mx-auto'
: '' ?>"
>

Voltar

</a>

</div>

</form>

</div>

</section>

</body>

</html>