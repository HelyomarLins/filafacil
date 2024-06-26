<?php
$senha = '12345';
$hashArmazenado = '$2y$12$oLaKHSr.zSWvWsTJ8KgQOO9VrDvg0Nh62S97wcp8NChUldgIqtHDS'; // Hash armazenado no banco

if (password_verify($senha, $hashArmazenado)) {
    echo "Senha verificada com sucesso.";
} else {
    echo "Falha na verificação da senha.";
}
