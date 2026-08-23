<?php
$clientes = $pdo->query("SELECT id_cliente, nm_pessoa, nr_cpf, nr_telefone FROM CLIENTE ORDER BY nm_pessoa")->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Clientes</h4>
    <button type="button" class="btn-lapis" data-bs-toggle="modal" data-bs-target="#modalCliente" onclick="novoCliente()" title="Adicionar cliente">
        <i class="bi bi-pencil-fill"></i>
    </button>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Telefone</th>
            <th class="text-end">Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($clientes) === 0): ?>
            <tr><td colspan="4" class="text-center text-muted py-4">Nenhum cliente cadastrado ainda.</td></tr>
        <?php endif; ?>
        <?php foreach ($clientes as $c): ?>
        <tr>
            <td><?= htmlspecialchars($c['nm_pessoa']) ?></td>
            <td><?= htmlspecialchars($c['nr_cpf']) ?></td>
            <td><?= htmlspecialchars($c['nr_telefone']) ?></td>
            <td class="text-end">
                <button class="btn-icone-editar" title="Editar"
                    onclick='editarCliente(<?= $c["id_cliente"] ?>, <?= json_encode($c["nm_pessoa"]) ?>, <?= json_encode($c["nr_cpf"]) ?>, <?= json_encode($c["nr_telefone"]) ?>)'
                    data-bs-toggle="modal" data-bs-target="#modalCliente">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn-icone-excluir" title="Excluir"
                    onclick="excluirCliente(<?= $c['id_cliente'] ?>, <?= json_encode($c['nm_pessoa']) ?>)">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="modal fade" id="modalCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="acoes/cliente_salvar.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalCliente">Novo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id_cliente" id="idCliente">

                    <label class="form-label">Nome</label>
                    <input type="text" name="nm_pessoa" id="nmPessoa" class="form-control mb-3" required maxlength="100">

                    <label class="form-label">CPF (somente números)</label>
                    <input type="text" name="nr_cpf" id="nrCpf" class="form-control mb-3" required maxlength="11" pattern="\d{11}">

                    <label class="form-label">Telefone (somente números)</label>
                    <input type="text" name="nr_telefone" id="nrTelefone" class="form-control" required maxlength="11" pattern="\d{10,11}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-laranja">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<form id="formExcluirCliente" action="acoes/cliente_excluir.php" method="POST" class="d-none">
    <input type="hidden" name="id_cliente" id="idClienteExcluir">
</form>

<script>
function novoCliente() {
    document.getElementById('tituloModalCliente').innerText = 'Novo Cliente';
    document.getElementById('idCliente').value = '';
    document.getElementById('nmPessoa').value = '';
    document.getElementById('nrCpf').value = '';
    document.getElementById('nrTelefone').value = '';
}

function editarCliente(id, nome, cpf, telefone) {
    document.getElementById('tituloModalCliente').innerText = 'Editar Cliente';
    document.getElementById('idCliente').value = id;
    document.getElementById('nmPessoa').value = nome;
    document.getElementById('nrCpf').value = cpf;
    document.getElementById('nrTelefone').value = telefone;
}

function excluirCliente(id, nome) {
    if (confirm('Deseja realmente excluir o cliente "' + nome + '"? Essa ação não pode ser desfeita.')) {
        document.getElementById('idClienteExcluir').value = id;
        document.getElementById('formExcluirCliente').submit();
    }
}
</script>