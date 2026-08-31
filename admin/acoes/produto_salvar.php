<?php
session_start();
if (!isset($_SESSION['admin_id'])) { header("Location: ../index.php"); exit; }
require "../../config.php";

$id = $_POST['id_produto'] ?? '';
$nome = trim($_POST['nm_produto'] ?? '');
$preco = $_POST['nr_preco'] ?? '';
$estoque = $_POST['nr_estoque'] ?? '';
$idCategoria = $_POST['id_categoria'] ?? '';
$descricao = trim($_POST['ds_descricao'] ?? '');
$imagemAtual = trim($_POST['ds_imagem_atual'] ?? '');

if ($nome === '' || $preco === '' || $estoque === '' || $idCategoria === '') {
    header("Location: ../painel.php?secao=produto");
    exit;
}

$nomeImagem = $imagemAtual;

if (isset($_FILES['arquivo_imagem']) && $_FILES['arquivo_imagem']['error'] === UPLOAD_ERR_OK) {
    
    $pastaDestino = "../../site/imagens/produtos/";
    $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'webp'];

    $nomeOriginal = $_FILES['arquivo_imagem']['name'];
    $extensao = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

    if (in_array($extensao, $extensoesPermitidas)) {
      
        $nomeImagem = uniqid('produto_') . '.' . $extensao;
        $caminhoCompleto = $pastaDestino . $nomeImagem;

        move_uploaded_file($_FILES['arquivo_imagem']['tmp_name'], $caminhoCompleto);
    }
}

if ($id === '') {
    $stmt = $pdo->prepare("INSERT INTO PRODUTO (nm_produto, nr_preco, nr_estoque, id_categoria, ds_descricao, ds_imagem) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nome, $preco, $estoque, $idCategoria, $descricao, $nomeImagem]);
} else {
    $stmt = $pdo->prepare("UPDATE PRODUTO SET nm_produto = ?, nr_preco = ?, nr_estoque = ?, id_categoria = ?, ds_descricao = ?, ds_imagem = ? WHERE id_produto = ?");
    $stmt->execute([$nome, $preco, $estoque, $idCategoria, $descricao, $nomeImagem, $id]);
}

header("Location: ../painel.php?secao=produto");
exit;