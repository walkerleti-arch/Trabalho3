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
function carregarDashboard() {
    return __awaiter(this, void 0, void 0, function* () {
        const resposta = yield fetch("dados_dashboard.php");
        const itens = yield resposta.json();
        const faturamentoTotal = itens.reduce((acumulador, item) => {
            const subtotal = item.nr_quantidade * parseFloat(item.nr_preco);
            return acumulador + subtotal;
        }, 0);
        const totalItensVendidos = itens.reduce((acumulador, item) => {
            return acumulador + item.nr_quantidade;
        }, 0);
        document.getElementById("faturamentoTotal").textContent =
            faturamentoTotal.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
        document.getElementById("totalItens").textContent = totalItensVendidos.toString();
    });
}
carregarDashboard();
