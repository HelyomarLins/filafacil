<?php
// verify_files.php

function verifyFiles($codAccess, $nome)
{
    global $conexao;

    // Prepara a consulta para verificar se há registros com o mesmo nome ou código de acesso
    $stmt = $conexao->prepare("SELECT cod_acess_fila FROM criarfila WHERE nome_fila = ? OR cod_acess_fila = ?");
    if ($stmt === false) {
        return false;
    }

    $stmt->bind_param("ss", $nome, $codAccess);
    $stmt->execute();
    if ($stmt->errno) {
        return false;
    }

    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();

        return true; // Retorna verdadeiro se encontrar algum registro com o mesmo nome ou código de acesso
    } else {
        $stmt->close();
        return false; // Retorna falso se nenhum registro for encontrado
    }
}
