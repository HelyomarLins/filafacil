<?php
// Função para criar o hash da senha
function criarHash($senha)
{
    $opcoes = [
        // Ajuste este valor para cima conforme necessário (recomenda-se iniciar em 12)
        'cost' => 12
    ];

    $hashSenha = password_hash($senha, PASSWORD_DEFAULT, $opcoes);
    // Retorna o hash da senha
    return $hashSenha;
}