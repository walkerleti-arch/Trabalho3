<?php
require '../config.php';

$sql = "
    SELECT p.id_produto, p.nm_produto, p.nr_preco, p.ds_imagem,
           c.id_categoria, c.nm_categoria
    FROM PRODUTO p
    INNER JOIN CATEGORIA c ON p.id_categoria = c.id_categoria
    WHERE p.fl_ativo = TRUE AND c.fl_ativo = TRUE
    ORDER BY c.nm_categoria, p.nm_produto
";
$produtos = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$categorias = [];
foreach ($produtos as $p) {
    $categorias[$p['id_categoria']] = $p['nm_categoria'];
}

$IMAGEM_PADRAO = "imagens/produtos/sem-foto.png";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depósito São José - Produtos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Barlow+Condensed:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="topo">
    <div class="topo-marca">
        <span class="marca-icone"></span>
        <div>
            <div class="marca-texto">Depósito São José</div>
            <div class="marca-sub">Materiais de Construção</div>
        </div>
    </div>
</header>

<main class="container">
    <h1 class="titulo-pagina">Nossos Produtos</h1>

    <div id="filtros" class="filtros">
        <button class="btn-filtro ativo" data-filtro="todos">Todos</button>
        <?php foreach ($categorias as $id => $nome): ?>
            <button class="btn-filtro" data-filtro="<?= $id ?>"><?= htmlspecialchars($nome) ?></button>
        <?php endforeach; ?>
    </div>

    <div id="areaProdutos" class="grade-produtos">
        <?php if (count($produtos) === 0): ?>
            <p class="mensagem-vazia">Nenhum produto disponível no momento.</p>
        <?php endif; ?>
        <?php foreach ($produtos as $p): ?>
            <?php
                $caminhoImagem = $p['ds_imagem']
                    ? "imagens/produtos/" . $p['ds_imagem']
                    : $IMAGEM_PADRAO;
            ?>
            <div class="card-produto" data-categoria="<?= $p['id_categoria'] ?>">
                <img src="<?= htmlspecialchars($caminhoImagem) ?>" alt="<?= htmlspecialchars($p['nm_produto']) ?>" class="card-imagem"
                     onerror="this.src='<?= $IMAGEM_PADRAO ?>'">
                <span class="card-categoria"><?= htmlspecialchars($p['nm_categoria']) ?></span>
                <div class="card-nome"><?= htmlspecialchars($p['nm_produto']) ?></div>
                <div class="card-preco">R$ <?= number_format($p['nr_preco'], 2, ',', '.') ?></div>
                <a href="produto.php?id=<?= $p['id_produto'] ?>" class="btn-ver-produto">Ver produto</a>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<script>
document.querySelectorAll('.btn-filtro').forEach(function (botao) {
    botao.addEventListener('click', function () {
        document.querySelectorAll('.btn-filtro').forEach(function (b) { b.classList.remove('ativo'); });
        botao.classList.add('ativo');

        var filtro = botao.getAttribute('data-filtro');
        document.querySelectorAll('.card-produto').forEach(function (card) {
            var mostrar = filtro === 'todos' || card.getAttribute('data-categoria') === filtro;
            card.style.display = mostrar ? '' : 'none';
        });
    });
});
</script>
</body>
</html>