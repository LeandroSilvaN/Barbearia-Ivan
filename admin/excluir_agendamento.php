<?php

require_once 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM agendamento WHERE id = $id";

mysqli_query($conn, $sql);

header("Location: agendamentos.php");
exit;