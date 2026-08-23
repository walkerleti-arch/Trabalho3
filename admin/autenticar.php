<?php
session_start();
require "../config.php";

$usuario = trim($_POST['usuario'] ?? '');
$senha = $_POST['senha'] ?? '';

if ($usuario === '' || $senha === '') {
    $_SESSION['erro_login'] = "Preencha usuário e senha.";
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("SELECT id_administrador, nm_usuario, ds_senha FROM ADMINISTRADOR WHERE nm_usuario = ? AND fl_ativo = TRUE");
$stmt->execute([$usuario]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if ($admin && password_verify($senha, $admin['ds_senha'])) {
    $_SESSION['admin_id'] = $admin['id_administrador'];
    $_SESSION['admin_usuario'] = $admin['nm_usuario'];
    header("Location: painel.php"); // próxima tela que você ainda vai criar
    exit;
} else {
    $_SESSION['erro_login'] = "Usuário ou senha inválidos.";
    header("Location: index.php");
    exit;
}