<?php
$produtos = $pdo->query("
    SELECT p.id_produto, p.nm_produto, p.nr_preco, p.nr_estoque, p.id_categoria, p.ds_descricao, p.ds_imagem, c.nm_categoria
    FROM PRODUTO p
    INNER JOIN CATEGORIA c ON p.id_categoria = c.id_categoria
    WHERE p.fl_ativo = TRUE AND c.fl_ativo = TRUE
    ORDER BY p.nm_produto
")->fetchAll(PDO::FETCH_ASSOC);

$categorias = $pdo->query("SELECT id_categoria, nm_categoria FROM CATEGORIA WHERE fl_ativo = TRUE ORDER BY nm_categoria")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Produtos</h4>
    <button type="button" class="btn-lapis" data-bs-toggle="modal" data-bs-target="#modalProduto" onclick="novoProduto()" title="Adicionar produto">
        <i class="bi bi-pencil-fill"></i>
    </button>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Preço</th>
            <th>Estoque</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($produtos) === 0): ?>
            <tr><td colspan="5" class="text-center text-muted py-4">Nenhum produto cadastrado ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($produtos as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['nm_produto']) ?></td>
            <td><?= htmlspecialchars($p['nm_categoria']) ?></td>
            <td>R$ <?= number_format($p['nr_preco'], 2, ',', '.') ?></td>
            <td><?= (int)$p['nr_estoque'] ?></td>
            <td class="text-end">
                <button class="btn-icone-editar" title="Editar"
                    onclick='editarProduto(<?= $p["id_produto"] ?>, <?= json_encode($p["nm_produto"]) ?>, <?= $p["nr_preco"] ?>, <?= (int)$p["nr_estoque"] ?>, <?= $p["id_categoria"] ?>, <?= json_encode($p["ds_descricao"] ?? "") ?>, <?= json_encode($p["ds_imagem"] ?? "") ?>)'
                    data-bs-toggle="modal" data-bs-target="#modalProduto">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-icone-excluir" title="Excluir"
                    onclick="excluirProduto(<?= $p['id_produto'] ?>, <?= json_encode($p['nm_produto']) ?>)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modalProduto" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="acoes/produto_salvar.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalProduto">Novo Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_produto" id="idProduto">
                    <input type="hidden" name="ds_imagem_atual" id="dsImagemAtual">

                    <label class="form-label">Nome do produto</label>
                    <input type="text" name="nm_produto" id="nmProduto" class="form-control mb-3" required maxlength="100">

                    <label class="form-label">Categoria</label>
                    <select name="id_categoria" id="idCategoriaProduto" class="form-select mb-3" required>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?= $cat['id_categoria'] ?>"><?= htmlspecialchars($cat['nm_categoria']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <div class="row">
                        <div class="col">
                            <label class="form-label">Preço (R$)</label>
                            <input type="number" step="0.01" min="0" name="nr_preco" id="nrPreco" class="form-control" required>
                        </div>
                        <div class="col">
                            <label class="form-label">Estoque</label>
                            <input type="number" min="0" name="nr_estoque" id="nrEstoque" class="form-control" required>
                        </div>
                    </div>

                    <label class="form-label mt-3">Descrição</label>
                    <textarea name="ds_descricao" id="dsDescricao" class="form-control" rows="3" maxlength="1000"></textarea>

                    <label class="form-label mt-3">Imagem do produto</label>
                    <input type="file" name="arquivo_imagem" id="arquivoImagem" class="form-control" accept="image/png, image/jpeg, image/webp">
                    <div id="previewImagemAtual" class="preview-imagem-atual"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-laranja">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="formExcluirProduto" action="acoes/produto_excluir.php" method="POST" class="d-none">
    <input type="hidden" name="id_produto" id="idProdutoExcluir">
</form>

<script>
function novoProduto() {
    document.getElementById('tituloModalProduto').innerText = 'Novo Produto';
    document.getElementById('idProduto').value = '';
    document.getElementById('nmProduto').value = '';
    document.getElementById('nrPreco').value = '';
    document.getElementById('nrEstoque').value = '';
    document.getElementById('idCategoriaProduto').selectedIndex = 0;
    document.getElementById('dsDescricao').value = '';
    document.getElementById('arquivoImagem').value = '';
    document.getElementById('dsImagemAtual').value = '';
    document.getElementById('previewImagemAtual').innerHTML = '';
}

function editarProduto(id, nome, preco, estoque, idCategoria, descricao, imagem) {
    document.getElementById('tituloModalProduto').innerText = 'Editar Produto';
    document.getElementById('idProduto').value = id;
    document.getElementById('nmProduto').value = nome;
    document.getElementById('nrPreco').value = preco;
    document.getElementById('nrEstoque').value = estoque;
    document.getElementById('idCategoriaProduto').value = idCategoria;
    document.getElementById('dsDescricao').value = descricao;
    document.getElementById('arquivoImagem').value = '';
    document.getElementById('dsImagemAtual').value = imagem;

    var preview = document.getElementById('previewImagemAtual');
    if (imagem) {
        preview.innerHTML = '<span>Imagem atual:</span><br><img src="../site/imagens/produtos/' + imagem + '" alt="Imagem atual">';
    } else {
        preview.innerHTML = '<span>Nenhuma imagem cadastrada ainda.</span>';
    }
}

function excluirProduto(id, nome) {
    if (confirm('Deseja realmente excluir o produto "' + nome + '"?')) {
        document.getElementById('idProdutoExcluir').value = id;
        document.getElementById('formExcluirProduto').submit();
    }
}
</script>