<?php

session_start();

include("../config/conection.php");

if(!isset($_SESSION['id'])){

    header("Location: ../auth/login.php");
    exit;

}

$id_usuario = $_SESSION['id'];

$id = $_GET['id'];


/* VERIFICA SE O AGENDAMENTO É DO USUÁRIO */

$sql = "

SELECT *
FROM agendamento
WHERE id = $id
AND cliente_id = $id_usuario

";

$resultado = mysqli_query(
$conn,
$sql
);


if(mysqli_num_rows($resultado)==0){

    die("Agendamento não encontrado.");

}


$agendamento = mysqli_fetch_assoc(
$resultado
);


/* BLOQUEIOS */

if(

    $agendamento['status']=="FINALIZADO"
    ||
    $agendamento['status']=="CANCELADO"

){

    die("Este agendamento não pode ser cancelado.");

}


if(

    strtotime($agendamento['data'])
    <
    strtotime(date('Y-m-d'))

){

    die("Não é permitido cancelar agendamentos passados.");

}


/* CANCELA */

$sql_cancelar="

UPDATE agendamento
SET status='CANCELADO'
WHERE id='$id'

";

mysqli_query(
$conn,
$sql_cancelar
);


header(
"Location: meus_agendamentos.php"
);

exit;

?>