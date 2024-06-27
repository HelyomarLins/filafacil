<?php
// access_1.php

ob_start();
session_start();
header('Content-Type: application/json');

// Incluindo arquivos de conexão
include_once('conexao.php');
include_once('./function/clear_input.php');
include_once('./function/criar_hash.php');
include_once('./function/verify_files.php');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Limpar e obter variáveis
        $tabela = clear_input($conexao, $_POST['tabela']);
        $id_criar_fila = isset($_POST['id_criar_fila']) ? clear_input($conexao, $_POST['id_criar_fila']) : null;

        // Remover variáveis do $_POST que não são campos de dados
        unset($_POST['tabela'], $_POST['id_criar_fila']);

        // Verificar se é uma operação de criação (INSERT) ou edição (UPDATE)
        $isUpdate = !empty($id_criar_fila); // Verifica se há um ID para determinar se é um UPDATE

        if ($isUpdate) {
            // Se for uma atualização, montar um UPDATE
            $sql = "UPDATE $tabela SET ";
            $campos = [];

            foreach ($_POST as $campo => $valor) {
                $campo = clear_input($conexao, $campo);
                $valor = clear_input($conexao, $valor);
                $campos[] = "$campo = ?";
            }

            $sql .= implode(", ", $campos);
            $sql .= " WHERE id_criar_fila = ?";

            // Preparar a declaração SQL
            $stmt = $conexao->prepare($sql);
            if ($stmt === false) {
                throw new Exception('Erro ao preparar a declaração: ' . $conexao->error);
            }

            // Vincular os parâmetros da query preparada
            $paramTypes = str_repeat('s', count($campos)) . 'i';
            $paramValues = array_values($_POST);
            $paramValues[] = $id_criar_fila;
            $stmt->bind_param($paramTypes, ...$paramValues);

            // Executar a query SQL preparada
            if ($stmt->execute()) {
                $response = [
                    'redirect' => '/Fila_Facil/system/usuario/listarFilasUsu.php',
                    'message' => 'Fila editada com sucesso',
                    'icon' => 'success'
                ];
            } else {
                $response = [
                    'message' => 'Erro ao editar a fila. Tente novamente',
                    'icon' => 'error'
                ];
            }

            $stmt->close();
        } else {
            // Caso contrário, é uma operação de criação (INSERT)
            $codAccess = clear_input($conexao, $_POST['cod_acess_fila']);
            $nome = clear_input($conexao, $_POST['nome_fila']);
            $qtd_fila = clear_input($conexao, $_POST['qtd_fila']);
            $pessoa_idUsu = clear_input($conexao, $_POST['pessoa_idUsu']);

            // Verificar se já existe uma fila com o mesmo código de acesso ou nome
            $exists = verifyFiles($codAccess, $nome); // Verifica se o nome ou o código de acesso já existem

            if ($exists) {
                // Fila com o mesmo código de acesso ou nome já existe
                $response = [
                    'message' => 'A fila já existe. Criar outra.',
                    'icon' => 'error'
                ];
                http_response_code(400); // Bad Request
            } else {
                // Hashear o código de acesso antes de inserir no banco de dados
                $codAccessHashed = criarHash($codAccess);

                // Preparar a query de INSERT
                $sql = "INSERT INTO $tabela (pessoa_idUsu, nome_fila, qtd_fila, cod_acess_fila) VALUES (?, ?, ?, ?)";

                // Preparar a declaração SQL
                $stmt = $conexao->prepare($sql);
                if ($stmt === false) {
                    throw new Exception('Erro ao preparar a declaração: ' . $conexao->error);
                }

                // Vincular os parâmetros da query preparada
                $stmt->bind_param("isss", $pessoa_idUsu, $nome, $qtd_fila, $codAccessHashed);

                // Executar a query SQL preparada
                if ($stmt->execute()) {
                    $response = [
                        'redirect' => '/Fila_Facil/system/usuario/listarFilasUsu.php',
                        'message' => 'Fila criada com sucesso',
                        'icon' => 'success'
                    ];
                } else {
                    $response = [
                        'message' => 'Erro ao criar a fila. Tente novamente',
                        'icon' => 'error'
                    ];
                }

                $stmt->close();
            }
        }
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
