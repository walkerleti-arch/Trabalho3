<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_cliente'] ?? '';

if ($id !== '') {
    $stmt = $pdo->prepare("DELETE FROM CLIENTE WHERE id_cliente = ?");
    $stmt->execute([$id]);
}

header("Location: ../painel.php?secao=cliente");
exit;