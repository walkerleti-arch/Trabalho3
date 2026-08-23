<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_venda'] ?? '';
$data = $_POST['dt_venda'] ?? '';
$valor = $_POST['nr_valor'] ?? '';
$idCliente = $_POST['id_cliente'] ?? '';

if ($data === '' || $valor === '' || $idCliente === '') {
    header("Location: ../painel.php?secao=venda");
    exit;
}

if ($id === '') {
    $stmt = $pdo->prepare("INSERT INTO VENDA (dt_venda, nr_valor, id_cliente) VALUES (?, ?, ?)");
    $stmt->execute([$data, $valor, $idCliente]);
} else {
    // Se o valor vier negativo aqui, o trigger vld_venda_negativo bloqueia o UPDATE
    $stmt = $pdo->prepare("UPDATE VENDA SET dt_venda = ?, nr_valor = ?, id_cliente = ? WHERE id_venda = ?");
    $stmt->execute([$data, $valor, $idCliente, $id]);
}

header("Location: ../painel.php?secao=venda");
exit;