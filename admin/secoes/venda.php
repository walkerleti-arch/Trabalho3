<?php
$vendas = $pdo->query("
    SELECT v.id_venda, v.dt_venda, v.nr_valor, v.id_cliente, c.nm_pessoa
    FROM VENDA v
    INNER JOIN CLIENTE c ON v.id_cliente = c.id_cliente
    ORDER BY v.dt_venda DESC
")->fetchAll(PDO::FETCH_ASSOC);

$clientes = $pdo->query("SELECT id_cliente, nm_pessoa FROM CLIENTE ORDER BY nm_pessoa")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Vendas</h4>
    <button type="button" class="btn-lapis" data-bs-toggle="modal" data-bs-target="#modalVenda" onclick="novaVenda()" title="Adicionar venda">
        <i class="bi bi-pencil-fill"></i>
    </button>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Data</th>
            <th>Cliente</th>
            <th>Valor</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($vendas) === 0): ?>
            <tr><td colspan="4" class="text-center text-muted py-4">Nenhuma venda registrada ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($vendas as $v): ?>
        <tr>
            <td><?= date('d/m/Y', strtotime($v['dt_venda'])) ?></td>
            <td><?= htmlspecialchars($v['nm_pessoa']) ?></td>
            <td>R$ <?= number_format($v['nr_valor'], 2, ',', '.') ?></td>
            <td class="text-end">
                <button class="btn-icone-editar" title="Editar"
                    onclick='editarVenda(<?= $v["id_venda"] ?>, <?= json_encode($v["dt_venda"]) ?>, <?= $v["nr_valor"] ?>, <?= $v["id_cliente"] ?>)'
                    data-bs-toggle="modal" data-bs-target="#modalVenda">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-icone-excluir" title="Excluir"
                    onclick="excluirVenda(<?= $v['id_venda'] ?>)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modalVenda" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="acoes/venda_salvar.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalVenda">Nova Venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_venda" id="idVenda">

                    <label class="form-label">Data da venda</label>
                    <input type="date" name="dt_venda" id="dtVenda" class="form-control mb-3" required>

                    <label class="form-label">Cliente</label>
                    <select name="id_cliente" id="idClienteVenda" class="form-select mb-3" required>
                        <?php foreach ($clientes as $cli): ?>
                            <option value="<?= $cli['id_cliente'] ?>"><?= htmlspecialchars($cli['nm_pessoa']) ?></option>
                        <?php endforeach; ?>
                    </select>

                    <label class="form-label">Valor total (R$)</label>
                    <input type="number" step="0.01" min="0" name="nr_valor" id="nrValor" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-laranja">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="formExcluirVenda" action="acoes/venda_excluir.php" method="POST" class="d-none">
    <input type="hidden" name="id_venda" id="idVendaExcluir">
</form>

<script>
function novaVenda() {
    document.getElementById('tituloModalVenda').innerText = 'Nova Venda';
    document.getElementById('idVenda').value = '';
    document.getElementById('dtVenda').value = '';
    document.getElementById('nrValor').value = '';
    document.getElementById('idClienteVenda').selectedIndex = 0;
}

function editarVenda(id, data, valor, idCliente) {
    document.getElementById('tituloModalVenda').innerText = 'Editar Venda';
    document.getElementById('idVenda').value = id;
    document.getElementById('dtVenda').value = data;
    document.getElementById('nrValor').value = valor;
    document.getElementById('idClienteVenda').value = idCliente;
}

function excluirVenda(id) {
    if (confirm('Deseja realmente excluir esta venda? Essa ação não pode ser desfeita.')) {
        document.getElementById('idVendaExcluir').value = id;
        document.getElementById('formExcluirVenda').submit();
    }
}
</script>