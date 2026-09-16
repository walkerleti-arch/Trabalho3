<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_categoria'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM PRODUTO WHERE id_categoria = ? AND fl_ativo = TRUE");
    $stmt->execute([$id]);
    $totalProdutos = $stmt->fetchColumn();

    if ($totalProdutos > 0) {
        $_SESSION['erro_categoria'] = "Não é possível excluir esta categoria: existem $totalProdutos produto(s) cadastrado(s) nela.";
    } else {
        $stmt = $pdo->prepare("UPDATE CATEGORIA SET fl_ativo = FALSE WHERE id_categoria = ?");
        $stmt->execute([$id]);
    }
}

header("Location: ../painel.php?secao=categoria");
exit;