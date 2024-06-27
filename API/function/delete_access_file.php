<?php
ob_start();
session_start();
header('Content-Type: application/json');

// Arquivo de CONEXAO
include_once("../conexao.php");

// Inicializa o array de resposta
$response = [];

// Verifica se o método da requisição é DELETE
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);

    // Verifica se o parâmetro 'id_chamada' existe na URL
    if (isset($_DELETE['id_chamada'])) {
        $id = $_DELETE['id_chamada'];

        // Prepara a query SQL com Prepared Statement
        $sql = "DELETE FROM filas_chamada WHERE id_chamada = ?";
        $stmt = mysqli_prepare($conexao, $sql);

        // Verifica se a query foi preparada com sucesso
        if ($stmt) {
            // Associa o parâmetro e define o tipo de dado (inteiro no caso de ID)
            mysqli_stmt_bind_param($stmt, "i", $id);

            // Executa a query
            if (mysqli_stmt_execute($stmt)) {
                // Exclusão bem-sucedida
                $response = [
                    'redirect' => '/Fila_Facil/index.php',
                    'status' => true,
                    'msg' => "Acesso à fila excluído com sucesso!",
                ];
            } else {
                // Erro na exclusão
                $response = [
                    'status' => false,
                    'msg' => "Erro ao excluir o acesso da fila. Tente novamente. Detalhes: " . mysqli_error($conexao)
                ];
            }

            // Fecha o Prepared Statement
            mysqli_stmt_close($stmt);
        } else {
            // Erro ao preparar a query
            $response = [
                'status' => false,
                'msg' => "Erro ao preparar a query: " . mysqli_error($conexao)
            ];
        }
    } else {
        // ID não encontrado na URL
        $response = [
            'status' => false,
            'msg' => "ID do fila chamada não encontrado na requisição."
        ];
    }
} else {
    // Método não permitido
    $response = [
        'status' => false,
        'msg' => "Método não permitido."
    ];
}

// Fecha a conexão 
mysqli_close($conexao);

// Limpa qualquer saída antes de enviar o JSON
ob_end_clean();

// Retorna os dados JSON
header('Content-Type: application/json');
echo json_encode($response);
