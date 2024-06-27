<?php
ob_start();
session_start();
header('Content-Type: application/json');

// Arquivo de CONEXAO
include_once("conexao.php");

// Inicializa o array de resposta
$response = [];

// Verifica se o parâmetro 'id_usu' existe na URL
if (isset($_REQUEST['id_chamada'])) {
    $id = $_REQUEST['id_usu'];

    // Prepara a query SQL com Prepared Statement
    $sql = "DELETE FROM filas_chamada WHERE id_usu = ?";
    $stmt = mysqli_prepare($conexao, $sql);

    // Verifica se a query foi preparada com sucesso
    if ($stmt) {
        // Associa o parâmetro e define o tipo de dado (inteiro no caso de ID)
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Executa a query
        if (mysqli_stmt_execute($stmt)) {
            // Exclusão bem-sucedida
            $response = [
                'redirect' => '/sidebar-01/sistema/usuario/listarUsuarios.php',
                'status' => true,
                'msg' => "Usuário excluído com sucesso!",

            ];
        } else {
            // Erro na exclusão
            $response = [
                'status' => false,
                'msg' => "Erro ao excluir o usuário. Tente novamente. Detalhes: " . mysqli_error($conexao)
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
        'msg' => "ID do usuário não encontrado na requisição."
    ];
}

// Fecha a conexão 
mysqli_close($conexao);

// Limpa qualquer saída antes de enviar o JSON
ob_end_clean();

// Retorna os dados JSON
header('Content-Type: application/json');
echo json_encode($response);
