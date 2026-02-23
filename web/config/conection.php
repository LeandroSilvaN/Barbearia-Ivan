<?php
$DB_HOST="myhost";
$DB_NAME="mydb";
$DB_USER="user";
$DB_PASSWORD="user";

try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", "$DB_USER", "$DB_PASSWORD");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $err) {
    die("err DB: " . $err->getMessage());
}

?>