<?php
include 'conection.php';

// Obtém os dados do item atualizado enviados pelo JavaScript
$item_id = isset($_POST['item_id']) ? $_POST['item_id'] : '';
$node = $_POST['node'];
$cto = $_POST['cto'];
$portas_livres = $_POST['portas_livres'];
$sinal = $_POST['sinal'];

error_log("Dados recebidos: item_id: $item_id, node: $node, cto: $cto, portas_livres: $portas_livres, sinal: $sinal", 0);

// Atualiza os dados no banco de dados
$query = "UPDATE tabela SET node = ?, cto = ?, portas_livres = ?, sinal = ? WHERE item_id = ?";
$stmt = $conn->prepare($query);

if (!$stmt) {
    error_log("Erro ao preparar a consulta: " . $conn->error, 0);
    die("Erro ao preparar a consulta: " . $conn->error);
}

$result = $stmt->bind_param("ssssi", $node, $cto, $portas_livres, $sinal, $item_id);

if (!$result) {
    error_log("Erro ao vincular parâmetros: " . $stmt->error, 0);
    die("Erro ao vincular parâmetros: " . $stmt->error);
}

$result = $stmt->execute();

if (!$result) {
    error_log("Erro ao executar a consulta: " . $stmt->error, 0);
    die("Erro ao executar a consulta: " . $stmt->error);
}

echo "Dados atualizados com sucesso!";


$conn->close();
?>
