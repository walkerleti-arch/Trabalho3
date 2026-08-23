<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_produto'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("UPDATE PRODUTO SET fl_ativo = FALSE WHERE id_produto = ?");
    $stmt->execute([$id]);
}

header("Location: ../painel.php?secao=produto");
exit;