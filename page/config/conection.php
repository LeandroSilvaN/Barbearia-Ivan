<?php

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "barbearia_ivan";

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro ao conectar:" . mysqli_connect_error());
}

?>