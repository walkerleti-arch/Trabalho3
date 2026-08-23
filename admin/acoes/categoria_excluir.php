<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_categoria'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("UPDATE CATEGORIA SET fl_ativo = FALSE WHERE id_categoria = ?");
    $stmt->execute([$id]);
}

header("Location: ../painel.php?secao=categoria");
exit;