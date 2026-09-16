<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_cliente'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM VENDA WHERE id_cliente = ?");
    $stmt->execute([$id]);
    $totalVendas = $stmt->fetchColumn();

    if ($totalVendas > 0) {
        $_SESSION['erro_cliente'] = "Não é possível excluir este cliente: existem $totalVendas venda(s) registrada(s) para ele.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM CLIENTE WHERE id_cliente = ?");
        $stmt->execute([$id]);
    }
}

header("Location: ../painel.php?secao=cliente");
exit;