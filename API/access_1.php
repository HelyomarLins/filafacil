<?php
ob_start();
session_start();
header('Content-Type: application/json');

// Incluindo arquivos de conexão
include_once('conexao.php');
include_once('./function/clear_input.php');
include_once('./API/function/criar_hash.php');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Limpar e obter variáveis
        $tabela = clear_input($conexao, $_POST['tabela']);
        $idCampo = clear_input($conexao, $_POST['idCampo']); // Pode não ser usado no INSERT
        $idValor = clear_input($conexao, $_POST['id_usu']); // Usar diretamente para edição, se necessário

        // Remover variáveis do $_POST que não são campos de dados
        unset($_POST['tabela'], $_POST['idCampo'], $_POST['id_usu']);

        // Verificar se é uma operação de criação (INSERT) ou edição (UPDATE)
        $isUpdate = !empty($idValor); // Verifica se há um ID para determinar se é um UPDATE

        if ($isUpdate) {
            // Se for uma atualização, montar um UPDATE
            $sql = "UPDATE $tabela SET ";
            $campos = [];

            foreach ($_POST as $campo => $valor) {
                $campo = clear_input($conexao, $campo);

                if ($campo === 'cod_acess_fila') {
                    // Se for o campo 'cod_acess_fila', aplicar a função de hash
                    $valor = criarHash($valor);
                } else {
                    $valor = clear_input($conexao, $valor);
                }
                $campos[] = "$campo = ?";
            }

            $sql .= implode(", ", $campos);
            $sql .= " WHERE $idCampo = ?";
        } else {
            // Caso contrário, é uma operação de criação (INSERT)
            $sql = "INSERT INTO $tabela (";
            $campos = [];
            $valores = [];

            foreach ($_POST as $campo => $valor) {
                $campo = clear_input($conexao, $campo);
                $valores[] = "?";

                if ($campo === 'cod_acess_fila') {
                    // Se for o campo 'cod_acess_fila', aplicar a função de hash
                    $valor = criarHash($valor);
                } else {
                    $valor = clear_input($conexao, $valor);
                }
                $campos[] = $campo;
            }

            $sql .= implode(", ", $campos);
            $sql .= ") VALUES (";
            $sql .= implode(", ", $valores);
            $sql .= ")";
        }

        // Preparar a declaração SQL
        $stmt = $conexao->prepare($sql);
        if ($stmt === false) {
            throw new Exception('Erro ao preparar a declaração: ' . $conexao->error);
        }

        // Vincular os parâmetros da query preparada
        $types = str_repeat('s', count($_POST)); // 's' para string
        $params = array_values($_POST);
        $stmt->bind_param($types, ...$params);

        // Executar a query SQL preparada
        if ($stmt->execute()) {
            if ($isUpdate) {
                $response = [
                    'redirect' => '/Fila_Facil/system/usuario/listarFilasUsu.php',
                    'message' => 'Fila atualizada com sucesso',
                    'icon' => 'success'
                ];
            } else {
                $response = [
                    'redirect' => '/Fila_Facil/system/usuario/listarFilasUsu.php',
                    'message' => 'Fila criada com sucesso',
                    'icon' => 'success'
                ];
            }
        } else {
            if ($isUpdate) {
                $response = [
                    'message' => 'Erro ao atualizar a fila. Tente novamente',
                    'icon' => 'error'
                ];
            } else {
                $response = [
                    'message' => 'Erro ao criar a fila. Tente novamente',
                    'icon' => 'error'
                ];
            }
        }

        $stmt->close();
    } catch (Exception $e) {
        // Capturar e tratar exceções
        $response = [
            'message' => 'Erro ao processar dados: ' . $e->getMessage(),
            'icon' => 'error'
        ];
        http_response_code(500); // Definir código de erro 500 para erro no servidor
        error_log("Erro: " . $e->getMessage()); // Log do erro
    }
} else {
    // Caso o método HTTP não seja POST
    $response = [
        'message' => 'Método inválido!',
        'icon' => 'error'
    ];
    http_response_code(405); // Definir código de erro 405 para método não permitido
}

mysqli_close($conexao); // Fechar conexão com banco de dados MySQLi
ob_end_clean(); // Limpar o buffer de saída (output buffer)
echo json_encode($response); // Retornar a resposta em JSON