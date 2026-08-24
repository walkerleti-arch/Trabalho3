<?php
$categorias = $pdo->query("SELECT id_categoria, nm_categoria FROM CATEGORIA WHERE fl_ativo = TRUE ORDER BY nm_categoria")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Categorias</h4>
    <button type="button" class="btn-lapis" data-bs-toggle="modal" data-bs-target="#modalCategoria" onclick="novaCategoria()" title="Adicionar categoria">
        <i class="bi bi-pencil-fill"></i>
    </button>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Nome da Categoria</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($categorias) === 0): ?>
            <tr><td colspan="2" class="text-center text-muted py-4">Nenhuma categoria cadastrada ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($categorias as $cat): ?>
        <tr>
            <td><?= htmlspecialchars($cat['nm_categoria']) ?></td>
            <td class="text-end">
                <button class="btn-icone-editar" title="Editar"
                    onclick="editarCategoria(<?= $cat['id_categoria'] ?>, '<?= htmlspecialchars($cat['nm_categoria'], ENT_QUOTES) ?>')"
                    data-bs-toggle="modal" data-bs-target="#modalCategoria">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-icone-excluir" title="Excluir"
                    onclick="excluirCategoria(<?= $cat['id_categoria'] ?>, '<?= htmlspecialchars($cat['nm_categoria'], ENT_QUOTES) ?>')">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modalCategoria" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="acoes/categoria_salvar.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalCategoria">Nova Categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_categoria" id="idCategoria">
                    <label class="form-label">Nome da categoria</label>
                    <input type="text" name="nm_categoria" id="nmCategoria" class="form-control" required maxlength="100">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-laranja">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="formExcluirCategoria" action="acoes/categoria_excluir.php" method="POST" class="d-none">
    <input type="hidden" name="id_categoria" id="idCategoriaExcluir">
</form>

<script>
function novaCategoria() {
    document.getElementById('tituloModalCategoria').innerText = 'Nova Categoria';
    document.getElementById('idCategoria').value = '';
    document.getElementById('nmCategoria').value = '';
}

function editarCategoria(id, nome) {
    document.getElementById('tituloModalCategoria').innerText = 'Editar Categoria';
    document.getElementById('idCategoria').value = id;
    document.getElementById('nmCategoria').value = nome;
}

function excluirCategoria(id, nome) {
    if (confirm('Deseja realmente excluir a categoria "' + nome + '"?')) {
        document.getElementById('idCategoriaExcluir').value = id;
        document.getElementById('formExcluirCategoria').submit();
    }
}
</script>