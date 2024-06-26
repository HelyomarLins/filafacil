<?php
// Arquivo de conexão com o banco de dados
include_once('conexao.php');

// Verifica se o parâmetro id_criar_fila foi recebido na URL
if (isset($_GET['id_criar_fila'])) {
    $id = $_GET['id_criar_fila'];

    // Consulta SQL para obter os detalhes da fila com o ID fornecido
    $sql = "SELECT * FROM criarfila WHERE id_criar_fila = $id";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        // Obtém os dados da primeira linha como um array associativo
        $fila = mysqli_fetch_assoc($result);

        // Converte os dados para JSON e envia de volta como resposta
        echo json_encode($fila);
    } else {
        // Em caso de erro na consulta
        echo json_encode(['error' => 'Erro ao consultar o banco de dados']);
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
} else {
    // Caso o parâmetro id_criar_fila não seja fornecido na URL
    echo json_encode(['error' => 'ID da fila não fornecido']);
}
