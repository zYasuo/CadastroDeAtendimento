<!DOCTYPE html>
<html>

<head>
    <title>Cadastro de Atendimento</title>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Language" content="pt-br">
    <link rel="icon" href="img/favicon1.png" type="image/x-icon" size="16x16">
    <link rel="stylesheet" type="text/css" href="tabelacss.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <header>
    
    </header>

    <h1>Cadastro de Atendimento</h1>

    

    <div id="scrollBtn">
        <button id="scrollBtnUp">&#8673;</button>
        <button id="scrollBtnDown">&#8675;</button>
    </div>
    <form id="filtro-data-form">
        <div class="form-group">
            <div class="teste-p">
                <label for="data-inicial" class="form-label inicial">Data Inicia</label>
            </div>
            <div class="teste-t">
                <input type="date" id="data-inicial" name="data-inicial-filtro" class="form-control" value="<?php echo date('D-m-y'); ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="data-final" class="form-label final">Data Final</label>
            <input type="date" id="data-final" name="data-final-filtro" class="form-control" value="<?php echo date('D-m-y'); ?>">
            <button type="submit" id="btn-filtro">Filtrar</button>
        </div>
    </form>


    <p id="total-td"></p>
    </form>
    <div id="cards">

        <div class="card">
            <h2>Instalação</h2>
            <p id=quantidade-inst></p>
        </div>
        <div class="card">
            <h2>Reparo</h2>
            <p id=quantidade-rep></p>
        </div>
        <div class="card">
            <h2>Mudança Endereço</h2>
            <p id=quantidade-ende></p>
        </div>
        <div class="card">
            <h2>Mudança de titularidade</h2>
            <p id=quantidade-titu></p>
        </div>
        <div class="card">
            <h2>Mudança de Tecnologia</h2>
            <p id=quantidade-tec></p>
        </div>
        <div class="card">
            <h2>Troca de Equipamento</h2>
            <p id=quantidade-equip></p>
        </div>
        <div class="card">
            <h2>Liberação de Portas</h2>
            <p id=quantidade-lib></p>
        </div>
        <div class="card">
            <h2>Migração</h2>
            <p id=quantidade-mig></p>
        </div>

    </div>

    <div class="form-div">

        <h1>Formulário</h1>
        <form id="form-1" class="form" method="POST" data-id="<?php echo $item_id ?>">


            <div class="form-group">
                <label for="id_cliente" class="form-label">ID Cliente:</label>
                <input type="text" id="id_cliente" name="id_cliente" placeholder="Colocar S/I, caso não tenha" class="form-control">
            </div>

            <div class="form-group">
                <label for="tecnico" class="form-label">Técnico:</label>
                <input type="text" id="tecnico" name="tecnico" class="form-control">
            </div>

            <div class="form-group">
                <label for="tipo_atendimento" class="form-label">Tipo de Atendimento:</label>
                <select id="tipo_atendimento" required name="tipo_atendimento" class="form-control">
                    <option value="">Escolha uma opção</option>
                    <option value="instalacao">Instalação</option>
                    <option value="reparo">Reparo</option>
                    <option value="mudanca_endereco">Mudança de Endereço</option>
                    <option value="mudanca_tecnologia">Mudança de Tecnologia</option>
                    <option value="mudanca_titularidade">Mudança de Titularidade</option>
                    <option value="troca_equipamento">Troca de Equipamento</option>
                    <option value="liberacao_portas">Liberação de Portas</option>
                    <option value="migracao">Migração</option>
                </select>
            </div>

            <div class="form-group">
                <label for="cidade" class="form-label">Cidade:</label>
                <select id="cidade" name="cidade" required class="form-control">
                    <option value="">Selecione uma cidade</option>
                    <option value="Rio Claro">Rio Claro</option>
                    <option value="Ajapi">Ajapi</option>
                    <option value="Santa Gertrudes">Santa Gertrudes</option>
                    <option value="Leme">Leme</option>
                    <option value="Mogi Guaçu">Mogi Guaçu</option>
                    <option value="Limeira do Oeste">Limeira do Oeste</option>
                    <option value="Alexandrita">Alexandrita</option>
                    <option value="Iturama">Iturama</option>
                    <option value="Carneirinho">Carneirinho</option>
                </select>
            </div>

            <div class="form-group">
                <label for="node" class="form-label">Node:</label>
                <input type="text" id="node" name="node" placeholder="Colocar S/I, caso não tenha" class="form-control">
            </div>

            <div class="form-group">
                <label for="cto" class="form-label">CTO:</label>
                <input type="text" id="cto" name="cto" placeholder="Colocar S/I, caso não tenha" class="form-control">
            </div>

            <div class="form-group">
                <label for="portas_livres" class="form-label">Portas Livres:</label>
                <input type="number" id="portas_livres" name="portas_livres" class="form-control">
            </div>

            <div class="form-group">
                <label for="sinal" class="form-label">Sinal:</label>
                <input type="text" id="sinal" name="sinal" placeholder="Colocar S/I, caso não tenha" class="form-control">
            </div>

            <div class="form-group">
                <label for="obs" class="form-label">Obs:</label>
                <textarea id="obs" name="obs" placeholder="Não é obrigatório" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="data" class="form-label">Data:</label>
                <input type="date" id="data" name="data" required class="form-control" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="form-group">
                <label for="atendente" class="form-label">Atendente:</label>
                <select id="atendente" name="atendente" required class="form-control">
                    <option value="">Selecione um atendente</option>
                    <option value="Mariana">Mariana</option>
                    <option value="Giovani">Giovani</option>
                    <option value="Pedro">Pedro</option>
                    <option value="Vinicius">Vinicius</option>
                    <option value="Matheus">Matheus</option>
                    <option value="Marina">Marina</option>
                    <option value="Lucas">Lucas</option>
                    <option value="Danilo">Danilo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="feito_via" class="form-label">Feito via:</label>
                <select id="feito_via" name="feito_via" class="form-control">
                    <option value="telefone">Telefone</option>
                    <option value="whatsapp">WhatsApp</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

    </div>
    <div>
       <select id="searchSelect" class="searchSelect" onchange="searchTable()">
        <option value="">Filtro</option>
        <option value="id_cliente">ID</option>
        <option value="tecnico">Nome Técnico</option>
        <option value="tipo_atendimento">Assunto</option>
        <option value="cidade">Cidade</option>
        <option value="node">Node</option>
        <option value="cto">CTO</option>
        <option value="portas_livres">Portas Livres</option>
        <option value="sinal">Sinal</option>
        <option value="atendente">Atendente</option>
        <option value="feito_via">Feito Via</option>
        <option value="obs">Observação</option>
        <option value="data">Data</option>
    </select>
    <input type="text" id="searchInput" class="searchInput" onkeyup="searchTable()" placeholder="Pesquisa Rápida">
    </div>
    <div>
    <select id="searchSelect2" class="searchSelect" onchange="searchTable()">
        <option value="">Filtro</option>
        <option value="id_cliente">ID</option>
        <option value="tecnico">Nome Técnico</option>
        <option value="tipo_atendimento">Assunto</option>
        <option value="cidade">Cidade</option>
        <option value="node">Node</option>
        <option value="cto">CTO</option>
        <option value="portas_livres">Portas Livres</option>
        <option value="sinal">Sinal</option>
        <option value="atendente">Atendente</option>
        <option value="feito_via">Feito Via</option>
        <option value="obs">Observação</option>
        <option value="data">Data</option>
    </select>
    <input type="text" id="searchInput2" class="searchInput" onkeyup="searchTable()" placeholder="Pesquisa Rápida">
    <button id="btn-xls" class="btn-xls" onclick="exportToXLS()" title="Baixar para XLS"><i class="fas fa-download"></i></button>
    <button id="limpar-filtro-button" class="btn-xls limpar">X</button>
    </div>
   

    <div id=pagination-div></div>

    <div id="list">

        <div class="myTable">

            <table id=table-index>
                <thead id="table-thead">
                    <tr id="tr-table">
                        <th name="id_cliente">ID</th>
                        <th name="tipo_atendimento">Nome Técnico</th>
                        <th name="tecnico">Assunto</th>
                        <th name="cidade">Cidade</th>
                        <th name="node">Node</th>
                        <th name="cto">CTO</th>
                        <th name="portas_livres">Portas Livres</th>
                        <th name="sinal">Sinal</th>
                        <th name="atendente">Atendente</th>
                        <th name="feito_via">Feito Via</th>
                        <th name="obs" id="thobs">Observação</th>
                        <th name="data">Data</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody id="table-tbody">
                    
                </tbody>
                <tfoot>
                    <td style="color: white;" colspan="11">Total de registros: <span id="quantidade-td"></span></td>
                </tfoot>
            </table>
            <form id="form-per-page">

            </form>
        </div>
        <div id="quantidade-td"></div>


</body>
<script src="main.js"></script>
</html>