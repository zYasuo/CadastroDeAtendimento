<?php
include 'conection.php';

// 2. Execute uma consulta SQL para buscar os dados
$sql = 'SELECT * FROM tabela';
$result = $conn->query($sql);

// 3. Exiba os dados na página
$dados = array();
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dados[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($dados);

$conn->close();
?>
