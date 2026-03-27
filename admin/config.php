<?php
session_start();

if (!isset($_SESSION['nome']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'ADMIN') {
    header("Location: ../page/auth/login.php");
    exit();
}

$host = "localhost";
$usuario = "root";
$senha = "";
$banco = "barbearia";

$conn = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conn) {
    die("Erro ao conectar:" . mysqli_connect_error());
}
