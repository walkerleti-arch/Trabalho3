<?php
// Ajuste esses dados conforme o seu ambiente (DBeaver/MariaDB local)
$host = "localhost";
$db   = "deposito2"; // troque pelo nome real do seu banco
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexao: " . $e->getMessage());
}