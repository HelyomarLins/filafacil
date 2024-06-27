<?php
include_once('../conexao.php');

$sql = "SELECT * FROM filas_chamada WHERE atendido = 'não'";
$result = $conexao->query($sql);

$chamadas = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chamadas[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($chamadas);
$conexao->close();
