<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_cliente'] ?? '';
$nome = trim($_POST['nm_pessoa'] ?? '');
$cpf = trim($_POST['nr_cpf'] ?? '');
$telefone = trim($_POST['nr_telefone'] ?? '');

if ($nome === '' || $cpf === '' || $telefone === '') {
    header("Location: ../painel.php?secao=cliente");
    exit;
}

if ($id === '') {
    $stmt = $pdo->prepare("INSERT INTO CLIENTE (nm_pessoa, nr_cpf, nr_telefone) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $cpf, $telefone]);
} else {
    $stmt = $pdo->prepare("UPDATE CLIENTE SET nm_pessoa = ?, nr_cpf = ?, nr_telefone = ? WHERE id_cliente = ?");
    $stmt->execute([$nome, $cpf, $telefone, $id]);
}

header("Location: ../painel.php?secao=cliente");
exit;