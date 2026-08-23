"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function mostrarMensagemVazia(mensagem) {
    const areaResultado = document.getElementById("areaDashboard");
    if (!areaResultado)
        return;
    areaResultado.innerHTML = `<p class="mensagem-vazia">${mensagem}</p>`;
}
function mostrarErro(mensagem) {
    const areaResultado = document.getElementById("areaDashboard");
    if (!areaResultado)
        return;
    areaResultado.innerHTML = `<p class="mensagem-erro">${mensagem}</p>`;
}
function carregarDashboard() {
    return __awaiter(this, void 0, void 0, function* () {
        let itens;
        try {
            const resposta = yield fetch("dados_dashboard.php");
            if (!resposta.ok) {
                mostrarErro("Não foi possível carregar os dados no momento.");
                return;
            }
            itens = yield resposta.json();
        }
        catch (erro) {
            mostrarErro("Não foi possível carregar os dados no momento.");
            return;
        }
        // Edge case 2: banco vazio (nenhuma venda registrada ainda)
        if (!itens || itens.length === 0) {
            mostrarMensagemVazia("Nenhum dado registrado.");
            return;
        }
        const faturamentoTotal = itens.reduce((acumulador, item) => {
            const preco = parseFloat(item.nr_preco);
            const quantidade = item.nr_quantidade;
            const precoValido = !isNaN(preco) ? preco : 0;
            const quantidadeValida = !isNaN(quantidade) ? quantidade : 0;
            return acumulador + (precoValido * quantidadeValida);
        }, 0);
        const totalItensVendidos = itens.reduce((acumulador, item) => {
            const quantidade = item.nr_quantidade;
            return acumulador + (!isNaN(quantidade) ? quantidade : 0);
        }, 0);
        renderizarDashboard(faturamentoTotal, totalItensVendidos);
    });
}
function renderizarDashboard(faturamentoTotal, totalItensVendidos) {
    const areaResultado = document.getElementById("areaDashboard");
    if (!areaResultado)
        return;
    const faturamentoFormatado = faturamentoTotal.toLocaleString("pt-BR", {
        style: "currency",
        currency: "BRL",
    });
    areaResultado.innerHTML = `
    <div class="card-metrica">
      <span class="metrica-label">Faturamento Total</span>
      <span class="metrica-valor">${faturamentoFormatado}</span>
    </div>
    <div class="card-metrica">
      <span class="metrica-label">Itens Vendidos</span>
      <span class="metrica-valor">${totalItensVendidos}</span>
    </div>
  `;
}
carregarDashboard();
