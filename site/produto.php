<?php
require '../config.php';
$fotosProdutos = [
    "Disjuntor Bipolar 40A" => "8.jpg",
    "Fio Elétrico 2.5mm (rolo 100m)" => "7.webp",
    "Furadeira de Impacto 550W" => "11.webp",
    "Trena 5m" => "12.webp",
    "Torneira Cromada Bancada" => "10.webp",
    "Tubo PVC Esgoto 100mm (barra 6m)" => "9.webp"
   
];

$IMAGEM_PADRAO = "sem-foto.png";

$id = $_GET['id'] ?? '';

if ($id === '') {
    header("Location: index.php");
    exit;
}

$stmt = $pdo->prepare("
    SELECT p.id_produto, p.nm_produto, p.nr_preco, p.nr_estoque, p.ds_descricao,
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

$nomeArquivo = $fotosProdutos[$produto['nm_produto']] ?? $IMAGEM_PADRAO;
$caminhoImagem = "imagens/" . $nomeArquivo;
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
    <link rel="stylesheet" href="css/style.css?v=12">
</head>
<body>

<header class="topo">
    <div class="topo-marca">
        <img src="imagens/logo.png" alt="Depósito São José" class="marca-icone-img">
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
                 onerror="this.onerror=null; this.src='imagens/<?= $IMAGEM_PADRAO ?>';">
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