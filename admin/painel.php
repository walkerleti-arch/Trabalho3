<?php
require "../config.php";
require "pages/header.php";

$secao = $_GET['secao'] ?? '';
$secoesValidas = ['dashboard', 'categoria', 'produto', 'venda', 'cliente'];

if (in_array($secao, $secoesValidas)) {
    include "secoes/{$secao}.php";
} else {
?>
    <h4 class="mb-3">Bem-vindo(a), <?= htmlspecialchars($_SESSION['admin_usuario']) ?></h4>
    <p class="text-muted">Selecione uma opção no menu acima para começar a gerenciar o depósito.</p>
<?php
}

require "pages/footer.php";