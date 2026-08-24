interface ItemVenda {
  id_venda: number;
  nr_quantidade: number;
  nr_preco: string;
}

function mostrarMensagemVazia(mensagem: string): void {
  const areaResultado = document.getElementById("areaDashboard");
  if (!areaResultado) return;
  areaResultado.innerHTML = `<p class="mensagem-vazia">${mensagem}</p>`;
}

function mostrarErro(mensagem: string): void {
  const areaResultado = document.getElementById("areaDashboard");
  if (!areaResultado) return;
  areaResultado.innerHTML = `<p class="mensagem-erro">${mensagem}</p>`;
}

async function carregarDashboard(): Promise<void> {
  let itens: ItemVenda[];

  try {
    const resposta = await fetch("dados_dashboard.php");
    if (!resposta.ok) {
      mostrarErro("Não foi possível carregar os dados no momento.");
      return;
    }
    itens = await resposta.json();
  } catch (erro) {
    mostrarErro("Não foi possível carregar os dados no momento.");
    return;
  }

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
}

function renderizarDashboard(faturamentoTotal: number, totalItensVendidos: number): void {
  const areaResultado = document.getElementById("areaDashboard");
  if (!areaResultado) return;

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