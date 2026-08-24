<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit;
}
$secaoAtual = $_GET['secao'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel - Depósito Central</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/painel.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid px-4">
        <a class="navbar-brand fw-bold" href="painel.php">
            <span class="brand-icone"></span> Depósito São José
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="menuPrincipal">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?= $secaoAtual === 'dashboard' ? 'active' : '' ?>" href="painel.php?secao=dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $secaoAtual === 'categoria' ? 'active' : '' ?>" href="painel.php?secao=categoria">Categorias</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $secaoAtual === 'produto' ? 'active' : '' ?>" href="painel.php?secao=produto">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $secaoAtual === 'venda' ? 'active' : '' ?>" href="painel.php?secao=venda">Vendas</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $secaoAtual === 'cliente' ? 'active' : '' ?>" href="painel.php?secao=cliente">Clientes</a>
                </li>
            </ul>
            <span class="navbar-text me-3">
                Olá, <?= htmlspecialchars($_SESSION['admin_usuario']) ?>
            </span>
            <a href="pages/logout.php" class="btn btn-outline-light btn-sm">Sair</a>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 py-4">
    <div class="quadro-branco">