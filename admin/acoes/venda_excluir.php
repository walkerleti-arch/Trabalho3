<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_venda'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM VENDA_PRODUTO WHERE id_venda = ?");
    $stmt->execute([$id]);
    $totalItens = $stmt->fetchColumn();

    if ($totalItens > 0) {
        $_SESSION['erro_venda'] = "Não é possível excluir esta venda: existem $totalItens produto(s) lançado(s) nela.";
    } else {
        $stmt = $pdo->prepare("DELETE FROM VENDA WHERE id_venda = ?");
        $stmt->execute([$id]);
    }
}

header("Location: ../painel.php?secao=venda");
exit;