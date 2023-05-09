<?php

// Conecção com o banco de dados
$servername = "localhost";
$username = "root";
$password = "zYasuo@123";
$dbname = "tabelacc";


// Mapeamento de tipos de atendimento
$tipo_atendimento_map = array(
  "reparo" => "Reparo",
  "mudanca_endereco" => "Mudança de Endereço",
  "liberacao_portas" => "Liberação de Portas",
  "mudanca_tecnologia" => "Mudança de Tecnologia",
  "instalacao" => "Instalação",
  "mudanca_titularidade" => "Mudança de Titularidade",
  "troca_equipamento" => "Troca de Equipamento",
  "migracao" => "Migração"
);

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}


// Função para inserir dados no banco de dados
function insertData($conn, $id_cliente, $tipo_atendimento, $tecnico, $node, $cto, $portas_livres, $sinal, $feito_via, $obs, $data, $cidade, $atendente, $item_id) {


  // Prepara a declaração SQL
  $stmt = $conn->prepare("INSERT INTO tabela (id_cliente, tipo_atendimento, tecnico, node, cto, portas_livres, sinal, feito_via, obs, data, cidade, atendente, item_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
  
  // Imprime a declaração SQL para verificar se o valor da cidade está sendo passado corretamente
  $stmt->bind_param("ssssssssssss", $id_cliente, $tipo_atendimento, $tecnico, $node, $cto, $portas_livres, $sinal, $feito_via, $obs, $data, $atendente, $cidade, $item_id);

  // Executa a declaração SQL
  if ($stmt->execute()) {
    echo "Dados inseridos com sucesso";
  } else {
    echo "Erro ao inserir dados: " . $stmt->error;
  }
  // Fecha o statement
  $stmt->close();
}



// Recebimento dos dados do formulário
$id_cliente = isset($_POST['id_cliente']) ? htmlspecialchars($_POST['id_cliente']) : '';
$tecnico = isset($_POST['tecnico']) ? htmlspecialchars($_POST['tecnico']) : '';
$tipo_atendimento = isset($_POST['tipo_atendimento']) ? htmlspecialchars($_POST['tipo_atendimento']) : '';
$atendente = isset($_POST['atendente']) ? htmlspecialchars($_POST['atendente']) : '';
$node = isset($_POST['node']) ? htmlspecialchars($_POST['node']) : '';
$cto = isset($_POST['cto']) ? htmlspecialchars($_POST['cto']) : '';
$portas_livres = isset($_POST['portas_livres']) ? htmlspecialchars($_POST['portas_livres']) : '';
$sinal = isset($_POST['sinal']) ? htmlspecialchars($_POST['sinal']) : '';
$feito_via = isset($_POST['feito_via']) ? htmlspecialchars($_POST['feito_via']) : '';
$obs = isset($_POST['obs']) ? htmlspecialchars($_POST['obs']) : '';
$data = isset($_POST['data']) ? date('d/m/Y', strtotime($_POST['data'])) : date('d/m/Y');
$cidade = isset($_POST['cidade']) ? htmlspecialchars($_POST['cidade']) : '';


// Verifica se o formulário foi submetido e o campo id_cliente não está vazio
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($id_cliente)) {
  // Inserção dos dados no banco de dados
  insertData($conn, $id_cliente, $tipo_atendimento, $tecnico, $node, $cto, $portas_livres, $sinal, $feito_via, $obs, $data, $cidade, $atendente, $item_id);
}

// Fechamento da conexão com o banco de dados
$conn->close();
?>
