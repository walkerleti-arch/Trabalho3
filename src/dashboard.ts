interface ItemVenda {
  id_venda: number;
  nr_quantidade: number;
  nr_preco: string;
  id_produto: number;
  nm_produto: string;
  id_categoria: number;
  nm_categoria: string;
}

interface ProdutoEstoque {
  id_produto: number;
  nm_produto: string;
  nr_estoque: number;
}

const LIMITE_ESTOQUE_CRITICO = 20;

let todosOsItens: ItemVenda[] = [];

function formatarMoeda(valor: number): string {
  return valor.toLocaleString("pt-BR", { style: "currency", currency: "BRL" });
}

function mostrarMensagem(areaId: string, mensagem: string, tipo: "vazia" | "erro" = "vazia"): void {
  const area = document.getElementById(areaId);
  if (area === null) return;
  const classe = tipo === "erro" ? "mensagem-erro" : "mensagem-vazia";
  area.innerHTML = `<p class="${classe}">${mensagem}</p>`;
}

async function carregarDashboard(): Promise<void> {
  try {
    const resposta = await fetch("dados_dashboard.php");
    if (!resposta.ok) {
      mostrarMensagem("areaDashboard", "Não foi possível carregar os dados no momento.", "erro");
      return;
    }
    const dados = (await resposta.json()) as ItemVenda[];
    todosOsItens = dados;
  } catch (erro) {
    mostrarMensagem("areaDashboard", "Não foi possível carregar os dados no momento.", "erro");
    return;
  }

  if (todosOsItens.length === 0) {
    mostrarMensagem("areaDashboard", "Nenhum dado registrado.");
    return;
  }

  montarFiltrosCategoria(todosOsItens);
  processarEExibir(todosOsItens);
}

function montarFiltrosCategoria(itens: ItemVenda[]): void {
  const areaFiltros = document.getElementById("filtrosDashboard");
  if (areaFiltros === null) return;

  const categoriasUnicas = new Map<number, string>();
  itens.forEach((item) => categoriasUnicas.set(item.id_categoria, item.nm_categoria));

  let html = `<button class="btn-filtro ativo" data-id="todas">Todas as categorias</button>`;
  categoriasUnicas.forEach((nome, id) => {
    html += `<button class="btn-filtro" data-id="${id}">${nome}</button>`;
  });
  areaFiltros.innerHTML = html;

  const botoes = areaFiltros.querySelectorAll(".btn-filtro");
  botoes.forEach((botao) => {
    botao.addEventListener("click", () => {
      botoes.forEach((b) => b.classList.remove("ativo"));
      botao.classList.add("ativo");

      const idAttr = botao.getAttribute("data-id");
      const itensFiltrados = idAttr === "todas"
        ? todosOsItens
        : todosOsItens.filter((item) => item.id_categoria === parseInt(idAttr ?? "0", 10));

      processarEExibir(itensFiltrados);
    });
  });
}

function processarEExibir(itens: ItemVenda[]): void {
  if (itens.length === 0) {
    mostrarMensagem("areaDashboard", "Nenhuma venda nessa categoria.");
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

  renderizarCards(faturamentoTotal, totalItensVendidos);
}

function renderizarCards(faturamentoTotal: number, totalItensVendidos: number): void {
  const areaResultado = document.getElementById("areaDashboard");
  if (areaResultado === null) return;

  areaResultado.innerHTML = `
    <div class="card-metrica">
      <span class="metrica-label">Faturamento Total</span>
      <span class="metrica-valor">${formatarMoeda(faturamentoTotal)}</span>
    </div>
    <div class="card-metrica">
      <span class="metrica-label">Itens Vendidos</span>
      <span class="metrica-valor">${totalItensVendidos}</span>
    </div>
  `;
}

async function carregarEstoqueCritico(): Promise<void> {
  let produtos: ProdutoEstoque[];

  try {
    const resposta = await fetch("dados_estoque.php");
    if (!resposta.ok) {
      mostrarMensagem("areaEstoqueCritico", "Não foi possível carregar o estoque no momento.", "erro");
      return;
    }
    produtos = (await resposta.json()) as ProdutoEstoque[];
  } catch (erro) {
    mostrarMensagem("areaEstoqueCritico", "Não foi possível carregar o estoque no momento.", "erro");
    return;
  }

  if (produtos.length === 0) {
    mostrarMensagem("areaEstoqueCritico", "Nenhum produto cadastrado.");
    return;
  }

  const produtosCriticos = produtos.filter((p) => p.nr_estoque <= LIMITE_ESTOQUE_CRITICO);

  const area = document.getElementById("areaEstoqueCritico");
  if (area === null) return;

  if (produtosCriticos.length === 0) {
    area.innerHTML = `<p class="mensagem-vazia">Nenhum produto com estoque crítico no momento.</p>`;
    return;
  }

  area.innerHTML = `
    <ul class="lista-estoque-critico">
      ${produtosCriticos.map((p) => `
        <li>
          <span>${p.nm_produto}</span>
          <span class="estoque-badge">${p.nr_estoque} un.</span>
        </li>
      `).join("")}
    </ul>
  `;
}

carregarDashboard();
carregarEstoqueCritico();