<?php

$servername = "localhost";
$username = "root";
$password = "exemplo";
$dbname = "tabelacc";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

?>
