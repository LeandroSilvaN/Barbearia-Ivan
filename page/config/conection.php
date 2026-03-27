<?php
    
$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "barbearia";

$conn = mysqli_connect($host,$usuario,$senha,$banco);

if(!$conn) {
    die("Erro ao conectar:" . mysqli_connect_error());
}

?>