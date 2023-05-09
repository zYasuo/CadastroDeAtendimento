const itemList = [];
const tableBody = document.getElementById('table-tbody');

const itemsPerPage = 5;
let currentPage = 1;



function getTotalPages() {
  return Math.ceil(itemList.length / itemsPerPage);
}

const paginationDiv = document.getElementById('pagination-div');
function updatePagination() {
  const totalPages = getTotalPages();
  const paginationDiv = document.getElementById('pagination-div');
  if (paginationDiv) {
    paginationDiv.innerHTML = '';
    for (let i = 1; i <= totalPages; i++) {
      const button = document.createElement('button');
      button.textContent = i;
      button.addEventListener('click', function() {
        currentPage = i;
        updateTable();
        updatePagination();
      });
      if (i === currentPage) {
        button.classList.add('active');
      }
      paginationDiv.appendChild(button);
    }
  }
}


//Enviando os dados para a tabela
document.querySelector('#form-1').addEventListener('submit', async (event) => {
  event.preventDefault();
  const formData = new FormData(event.target);
  const id_cliente = formData.get('id_cliente');
  const tecnico = formData.get('tecnico');
  const tipo_atendimento = formData.get('tipo_atendimento');
  const cidade = formData.get('cidade');
  const node = formData.get('node');
  const cto = formData.get('cto');
  const portas_livres = formData.get('portas_livres');
  const sinal = formData.get('sinal');
  const atendente = formData.get('atendente');
  const feito_via = formData.get('feito_via');
  const obs = formData.get('obs');
  const itemID = formData.get('item_id');
  const data = new Date(formData.get('data')).toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric' });

  if (id_cliente && tecnico && tipo_atendimento && cidade && node && cto && portas_livres && sinal && atendente && feito_via && data) {
    try {
      const response = await fetch('php/insertDados.php', {
        method: 'POST',
        body: formData
      });
      if (response.ok) {
        console.log('Dados inseridos com sucesso');
        event.target.reset(); // Limpa o formulário após o envio
        
        // Adiciona o novo item na tabela
        const newItem = Object.fromEntries(formData.entries());
        newItem.data = data; // adiciona a data formatada
        itemList.push(newItem);
        updateTable();
      } else {
        console.error('Erro ao inserir dados');
      }
    } catch (error) {
      console.error(error);
    }
  } else {
    console.log('Por favor, preencha todos os campos antes de enviar o formulário');
  }
});


async function preencherTabela() {
  try {
    const response = await fetch('php/returnDados.php');
    const items = await response.json();
    itemList.length = 0;
    itemList.push(...items);

    // Ordena a lista em ordem crescente e inverte a ordem para torná-la em ordem decrescente
    itemList.sort((a, b) => (a.id < b.id) ? 1 : -1);
    
    if (itemList.length > 0) {
      currentPage = 1; // reset current page to 1
      updateTable();
      updatePagination();
    } else {
      tableBody.innerHTML = '';
    }
  } catch (error) {
    console.error(error);
  }
}

function updateTable() {
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const itemsToDisplay = itemList.slice(startIndex, endIndex);

  tableBody.innerHTML = itemsToDisplay
    .map((item, index) => `
      <tr class="${index % 2 == 0 ? "white" : "gray"}" data-item-id="${item.item_id}">
        <td>${item.id_cliente}</td>
        <td>${item.tecnico}</td>
        <td>${item.tipo_atendimento}</td>
        <td>${item.cidade}</td>
        <td>${item.node}</td>
        <td>${item.cto}</td>
        <td>${item.portas_livres}</td>
        <td>${item.sinal}</td>
        <td>${item.atendente}</td>
        <td>${item.feito_via}</td>
        <td class="obs-td">${item.obs}</td>
        <td>${item.data}</td>
        <td><button class="edit-button actions-cell" onclick="editRow(this.parentNode.parentNode)">Editar</button></td>
      </tr>
    `)
    .join('');

  updateQuantity();
}

function updatePagination() {
  const totalPages = getTotalPages();
  const paginationDiv = document.getElementById('pagination-div');
  paginationDiv.innerHTML = '';
  for (let i = 1; i <= totalPages; i++) {
    const button = document.createElement('button');
    button.textContent = i;
    button.addEventListener('click', function() {
      currentPage = i;
      updateTable();
      updatePagination();
    });
    if (i === currentPage) {
      button.classList.add('active');
    }
    paginationDiv.appendChild(button);
  }
}

function updateTableAndPagination() {
  updateTable();
  updatePagination();
}

function updateQuantity() {
  const quantityTd = document.getElementById("quantidade-td");
  quantityTd.innerHTML = tableBody.rows.length;

  const instalacaoP = document.getElementById("quantidade-inst");
  const reparoP = document.getElementById("quantidade-rep");
  const enderecooP = document.getElementById("quantidade-ende");
  const titularidadeoP = document.getElementById("quantidade-titu");
  const equipamentoP = document.getElementById("quantidade-equip");
  const liberacaoP = document.getElementById("quantidade-lib");
  const migracaoP = document.getElementById("quantidade-mig");
  const tecnologiaoP = document.getElementById("quantidade-tec");

  instalacaoP.innerHTML = `${getQuantityByType('Instalação')} `;
  reparoP.innerHTML = `${getQuantityByType('Reparo')}`;
  enderecooP.innerHTML = `${getQuantityByType('Mudança de Endereço')}`;
  titularidadeoP.innerHTML = `${getQuantityByType('Mudança de Titularidade')}`;
  equipamentoP.innerHTML = `${getQuantityByType('Troca de Equipamento')}`;
  liberacaoP.innerHTML = `${getQuantityByType('Liberação de Portas')}`;
  migracaoP.innerHTML = `${getQuantityByType('Migração')}`;
  tecnologiaoP.innerHTML = `${getQuantityByType('Migração')}`
}

function searchTable() {
  // Obter o valor do select de campo de pesquisa
  let select1 = document.getElementById("searchSelect");
  let column1 = select1.value;
  let input1 = document.getElementById("searchInput");
  let filter1 = input1.value.toUpperCase();

  let select2 = document.getElementById("searchSelect2");
  let column2 = select2.value;
  let input2 = document.getElementById("searchInput2");
  let filter2 = input2.value.toUpperCase();

  // Obter os itens que correspondem ao filtro de pesquisa
  let filteredItems = itemList.filter((item) => {
    let itemValue1 = String(item[column1]).toUpperCase();
    let itemValue2 = String(item[column2]).toUpperCase();
    return itemValue1.indexOf(filter1) > -1 && itemValue2.indexOf(filter2) > -1;
  });

  // Atualizar a tabela com os itens filtrados
  const totalPages = Math.ceil(filteredItems.length / itemsPerPage);
  const startIndex = (currentPage - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  const itemsToDisplay = filteredItems.slice(startIndex, endIndex);
  tableBody.innerHTML = itemsToDisplay
    .map(
      (item, index) => `
      <tr class="${index % 2 == 0 ? "white" : "gray"}">
        <td>${item.id_cliente}</td>
        <td>${item.tecnico}</td>
        <td>${item.tipo_atendimento.replace(/_/g, " ")}</td>
        <td>${item.cidade}</td>
        <td>${item.node}</td>
        <td>${item.cto}</td>
        <td>${item.portas_livres}</td>
        <td>${item.sinal}</td>
        <td>${item.atendente}</td>
        <td>${item.feito_via}</td>
        <td class="obs-td">${item.obs}</td>
        <td>${item.data}</td>
        <td><button class="edit-button actions-cell" onclick="editRow(this.parentNode.parentNode)">Editar</button></td>
      </tr>
    `
    )
    .join("");

  updateQuantity();
  // Atualizar a paginação com o número correto de páginas
  paginationDiv.innerHTML = '';
  for (let i = 1; i <= totalPages; i++) {
    const button = document.createElement('button');
    button.textContent = i;
    button.addEventListener('click', function() {
      currentPage = i;
      searchTable(); // Atualizar a tabela com a nova página
      updatePagination();
    });
    if (i === currentPage) {
      button.classList.add('active');
    }
    paginationDiv.appendChild(button);
  }
}

// Obter o botão de rolagem para cima e o botão de rolagem para baixo
const scrollBtnUp = document.getElementById("scrollBtnUp");
const scrollBtnDown = document.getElementById("scrollBtnDown");

// Atualizar o estado dos botões de rolagem com base na posição da página
function updateScrollButtons() {
  // Se a página estiver no topo, esconder o botão de rolagem para cima
  if (window.scrollY === 0) {
    scrollBtnUp.style.display = "none";
  } else {
    scrollBtnUp.style.display = "block";
  }

  // Se a página estiver no final, esconder o botão de rolagem para baixo
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
    scrollBtnDown.style.display = "none";
  } else {
    scrollBtnDown.style.display = "block";
  }
}

// Adicionar um evento de rolagem para a janela
window.addEventListener("scroll", updateScrollButtons);

// Quando a página for carregada, atualizar o estado dos botões de rolagem
window.addEventListener("load", updateScrollButtons);

// Quando o botão de rolagem para cima for clicado, fazer a página rolar para o topo
scrollBtnUp.addEventListener("click", () => {
  window.scrollTo({ top: 0, behavior: "smooth" });
});

// Quando o botão de rolagem para baixo for clicado, fazer a página rolar para o final
scrollBtnDown.addEventListener("click", () => {
  window.scrollTo({ top: document.body.offsetHeight, behavior: "smooth" });
});


function getQuantityByType(tipo_atendimento) {
  let quantity = 0;
  for (let i = 0; i < itemList.length; i++) {
    if (itemList[i].tipo_atendimento === tipo_atendimento) {
      quantity++;
    }
  }
  return quantity;
}

function filterByDateAndSubject() {
  const dataInicialInput = document.getElementById("data-inicial");
  const dataFinalInput = document.getElementById("data-final");
  const dataInicial = new Date(dataInicialInput.value);
  const dataFinal = new Date(dataFinalInput.value);

  let totalInsta = 0;
  let totalReparo = 0;
  let totalEndereco = 0;
  let totalTec = 0;
  let totalTitu = 0;
  let totalEquip = 0;
  let totalPortas = 0;
  let totalMig = 0;


  itemList.forEach(item => {
    const itemData = new Date(item.data.split("/").reverse().join("-"));

    if (itemData >= dataInicial && itemData <= dataFinal) {
      if (item.tipo_atendimento === "Instalação") {
        totalInsta++;
      } else if (item.tipo_atendimento === "Reparo") {
        totalReparo++;
      }else if (item.tipo_atendimento === "Mudança de Endereço") {
        totalEndereco++;
      }else if (item.tipo_atendimento === "Mudança de Titularidade") {
        totalTitu++;
      }else if (item.tipo_atendimento === "Troca de Equipamento") {
        totalEquip++;
      }else if (item.tipo_atendimento === "Liberação de Portas") {
        totalPortas++;
      }else if (item.tipo_atendimento === "Migração") {
        totalMig++;
      }
      else if (item.tipo_atendimento === "Mudança de Tecnologia") {
        totalTec++;
      }
    }
  });

  const totalDiv = document.getElementById("total-td");
  totalDiv.classList.add("total-class");
  totalDiv.innerHTML = `Instalação: ${totalInsta} / Reparo: ${totalReparo} / Mudança de Endereco: ${totalEndereco} / Mudança de Titularidade: ${totalTitu} / Troca de Equipamento: ${totalEquip} / Liberação de Portas: ${totalPortas}  / Migração: ${totalMig} / Mudança de Tecnologia: ${totalTec}`;
}

// Adicionar evento 'submit' ao formulário de filtro de data
document.getElementById("filtro-data-form").addEventListener("submit", (event) => {
  event.preventDefault();
  const filteredItems = filterByDateAndSubject();
  updateQuantity(filteredItems);
});

  function exportToXLS() {
  const wb = XLSX.utils.table_to_book(document.querySelector("#table-index"), { sheet: "Sheet1" });
  XLSX.writeFile(wb, "tabela.xlsx");
}

const limparFiltroButton = document.getElementById("limpar-filtro-button");
limparFiltroButton.addEventListener("click", function () {
  // Limpa os campos de filtro
  const searchInput = document.getElementById("searchInput");
  const searchInput2 = document.getElementById("searchInput2");
  const dataInicialInput = document.getElementById("data-inicial");
  const dataFinalInput = document.getElementById("data-final");
  searchInput.value = "";
  searchInput2.value = "";
  dataInicialInput.value = "";
  dataFinalInput.value = "";

  // Carrega a tabela sem filtros
  preencherTabela();
});

function editRow(row) {
  row.classList.add("editing");
  const rowData = Array.from(row.children);

  rowData.forEach((cell, index) => {
    // Verifica se a célula está nas colunas desejadas (node, cto, sinal e portas_livres)
    if ([4, 5, 6, 7].includes(index)) {
      const input = document.createElement("input");
      input.value = cell.textContent;
      input.dataset.originalValue = cell.textContent;
      cell.textContent = "";
      cell.appendChild(input);
    }
  });

  
  const editBtn = row.querySelector("button");
  editBtn.style.display = "none";

  const headerRow = document.getElementById("table-thead").querySelector("tr");
  const headers = Array.from(headerRow.children);
  headers.pop(); // remove o último elemento (coluna "Ações")

headers.forEach((header, index) => {
  if (![4, 5, 6, 7].includes(index)) return;
  header.setAttribute("name", ["node", "cto", "sinal", "portas_livres"][index - 4]);
});


  const saveBtn = document.createElement("button");
  saveBtn.textContent = "Salvar";
  saveBtn.classList.add("edit-button");
  saveBtn.addEventListener("click", async function () {
    const inputs = row.querySelectorAll("input");
    const formData = new FormData();
    inputs.forEach((input, index) => {
      const cell = input.parentElement;
      const headerIndex = Array.from(cell.parentElement.children).indexOf(cell);
      formData.append(headers[headerIndex].getAttribute("name"), input.value);
    });
  
    // Adicione estas duas linhas
    const itemId = row.getAttribute("data-item-id");
    formData.append("item_id", itemId);
  
    try {
      const response = await fetch("php/editDados.php", {
        method: "POST",
        body: formData
      });
  

      if (response.ok) {
        console.log("Linha editada com sucesso" + id_cliente + node);
        rowData.forEach((cell, index) => {
      if ([4, 5, 6, 7].includes(index)) {
        cell.textContent = cell.querySelector("input").value;
      }
    });
        row.classList.remove("editing");
        editBtn.style.display = "inline";

        // Remove os botões "Salvar" e "Cancelar" da célula de ações
        const actionsCell = rowData[rowData.length - 1];
        actionsCell.innerHTML = '';
        actionsCell.appendChild(editBtn);
      } else {
        console.error("Erro ao editar linha");
      }
    } catch (error) {
      console.error(error);
    }
  });

  const cancelBtn = document.createElement("button");
  cancelBtn.textContent = "Cancelar";
  cancelBtn.classList.add("edit-button");
  cancelBtn.addEventListener("click", function () {
    rowData.forEach((cell, index) => {
      if ([4, 5, 6, 7].includes(index)) {
        cell.textContent = cell.querySelector("input").dataset.originalValue;
      }
    });
    row.classList.remove("editing");
    editBtn.style.display = "inline";

    // Remove os botões "Salvar" e "Cancelar" da célula de ações
    const actionsCell = rowData[rowData.length - 1];
    actionsCell.innerHTML = '';
    actionsCell.appendChild(editBtn);
  });

  const actionsCell = rowData[rowData.length - 1];

  // Adiciona os botões "Salvar" e "Cancelar" na célula de ações
  actionsCell.appendChild(saveBtn);
  actionsCell.appendChild(cancelBtn);
}

  
window.addEventListener("load", preencherTabela);
document.getElementById("searchInput").addEventListener("keyup", searchTable);
