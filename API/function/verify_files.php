<?php

function verifyFiles($codAccess, $nome)
{
    global $conexao;

    // Prepara a consulta para verificar o nome da fila
    $stmt = $conexao->prepare("SELECT cod_acess_fila FROM criarfila WHERE nome_fila = ?");
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param("s", $nome);
    $stmt->execute();
    if ($stmt->errno) {
        return false;
    }

    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($codAccessHashedDB);
        $stmt->fetch();

        // Verifica se o código de acesso fornecido corresponde ao hash no banco
        $codigo_exist = $codAccessHashedDB !== null && password_verify($codAccess, $codAccessHashedDB);

        $stmt->close();

        return array(
            'codigo_exist' => $codigo_exist,
            'nome_exist' => true
        );
    } else {
        $stmt->close();
        return array(
            'codigo_exist' => false,
            'nome_exist' => false
        );
    }
}
