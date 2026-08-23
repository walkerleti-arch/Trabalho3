<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_venda'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("DELETE FROM VENDA WHERE id_venda = ?");
    $stmt->execute([$id]);
}

header("Location: ../painel.php?secao=venda");
exit;