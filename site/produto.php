<?php
require '../config.php';

$id = $_GET['id'] ?? '';

if ($id === '') {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.id_produto, p.nm_produto, p.nr_preco, p.nr_estoque, p.ds_descricao, p.ds_imagem,
           c.nm_categoria
    FROM PRODUTO p
    INNER JOIN CATEGORIA c ON p.id_categoria = c.id_categoria
    WHERE p.id_produto = ? AND p.fl_ativo = TRUE AND c.fl_ativo = TRUE
");
$stmt->execute([$id]);
$produto = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produto) {
    header("Location: index.php");
    exit;
}

$IMAGEM_PADRAO = "imagens/produtos/sem-foto.png";
$caminhoImagem = $produto['ds_imagem'] ? "imagens/produtos/" . $produto['ds_imagem'] : $IMAGEM_PADRAO;
$descricao = $produto['ds_descricao'] ?: "Sem descrição cadastrada para este produto.";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produto['nm_produto']) ?> - Depósito São José</title>
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
    <a href="index.php" class="link-voltar">&larr; Voltar para produtos</a>

    <div class="detalhe-pagina">
        <div class="detalhe-imagem-area">
            <img src="<?= htmlspecialchars($caminhoImagem) ?>" alt="<?= htmlspecialchars($produto['nm_produto']) ?>"
                 onerror="this.src='<?= $IMAGEM_PADRAO ?>'">
        </div>

        <div class="detalhe-info-area">
            <span class="detalhe-categoria"><?= htmlspecialchars($produto['nm_categoria']) ?></span>
            <h1 class="detalhe-nome"><?= htmlspecialchars($produto['nm_produto']) ?></h1>
            <p class="detalhe-descricao"><?= nl2br(htmlspecialchars($descricao)) ?></p>
            <div class="detalhe-preco">R$ <?= number_format($produto['nr_preco'], 2, ',', '.') ?></div>
            <div class="detalhe-estoque">
                <?= $produto['nr_estoque'] > 0 ? (int)$produto['nr_estoque'] . ' unidades em estoque' : 'Sem estoque no momento' ?>
            </div>
        </div>
    </div>
</main>

</body>
</html>