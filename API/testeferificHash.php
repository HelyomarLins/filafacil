<?php
$senha = 'banda';
$hashArmazenado = '$2y$12$uvHCZHbYm63vj4mnYFJSLeNL/S.4V/iURkB1vqUufFbgAr1KYwrpW'; // Hash armazenado no banco

if (password_verify($senha, $hashArmazenado)) {
    echo "Senha verificada com sucesso.";
} else {
    echo "Falha na verificação da senha.";
}
