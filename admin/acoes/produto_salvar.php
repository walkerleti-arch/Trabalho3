<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_produto'] ?? '';
$nome = trim($_POST['nm_produto'] ?? '');
$preco = $_POST['nr_preco'] ?? '';
$estoque = $_POST['nr_estoque'] ?? '';
$idCategoria = $_POST['id_categoria'] ?? '';

if ($nome === '' || $preco === '' || $estoque === '' || $idCategoria === '') {
    header("Location: ../painel.php?secao=produto");
    exit;
}

if ($id === '') {
    $stmt = $pdo->prepare("INSERT INTO PRODUTO (nm_produto, nr_preco, nr_estoque, id_categoria) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $preco, $estoque, $idCategoria]);
} else {
    $stmt = $pdo->prepare("UPDATE PRODUTO SET nm_produto = ?, nr_preco = ?, nr_estoque = ?, id_categoria = ? WHERE id_produto = ?");
    $stmt->execute([$nome, $preco, $estoque, $idCategoria, $id]);
}

header("Location: ../painel.php?secao=produto");
exit;