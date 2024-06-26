<?php

include_once('./function/criar_hash.php'); // Inclui a função

$codigoAcesso = "12345"; // Código de acesso que você quer hashear
$hash = criarHash($codigoAcesso);

echo "Hash do código de acesso '$codigoAcesso': $hash\n";
