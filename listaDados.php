<?php
// 1. Conecte-se ao banco de dados usando PDO
$dsn = 'mysql:host=localhost;dbname=tabelacc';
$username = 'root';
$password = 'zYasuo@123';

try {
  $pdo = new PDO($dsn, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo 'Erro ao conectar com o banco de dados: ' . $e->getMessage();
}

// 2. Execute uma consulta SQL para buscar os dados
$sql = 'SELECT * FROM tabela';
$stmt = $pdo->prepare($sql);
$stmt->execute();
$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Exiba os dados na página
header('Content-Type: application/json');
echo json_encode($dados);

?>
