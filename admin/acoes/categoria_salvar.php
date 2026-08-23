<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_categoria'] ?? '';
$nome = trim($_POST['nm_categoria'] ?? '');

if ($nome === '') {
    header("Location: ../painel.php?secao=categoria");
    exit;
}

if ($id === '') {
    $stmt = $pdo->prepare("INSERT INTO CATEGORIA (nm_categoria) VALUES (?)");
    $stmt->execute([$nome]);
} else {
    $stmt = $pdo->prepare("UPDATE CATEGORIA SET nm_categoria = ? WHERE id_categoria = ?");
    $stmt->execute([$nome, $id]);
}

header("Location: ../painel.php?secao=categoria");
exit;