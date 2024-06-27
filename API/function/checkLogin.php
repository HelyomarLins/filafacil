<?php
// Verifica se a sessão já está ativa, se não, a inicia.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verifica se o usuário está logado
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    echo "Você precisa estar logado para acessar a aplicação.";
    // Redireciona para o index.php
    header("Location: /Fila_Facil/index.php");
    exit;
}

// Verifica o nível de acesso do usuário
$nivel_usu = $_SESSION['nivel_usu'];

// Define as permissões para cada página
$permissoes = [
    'sidebarN1.php' => [0, 1], //AMIN e Supervisão
    'sidebarN2.php' => [0, 1, 2], //Alunos
    'sidebarN3.php' => [0, 1, 3], //Secretaria
    'sidebarN4.php' => [0, 1, 4], //Funcionários
    'dash.php' => [0, 1, 2, 3, 4],

    // Permitir acesso para os níveis 
    //pasta usuarios
    'listarUsuarios.php' => [0, 1],
    'editaUsuario.php' => [0, 1], // Adicione a chave aqui

    //pasta produtos
    'listarProdutos.php' => [0, 1, 3, 4],
    'editaProduto.php' => [0, 1, 3, 4],

    //pasta funcionario
    'listarFuncionarios.php' => [0, 1, 4],
    'editaFuncionario.php' => [0, 1, 4],

    //pasta disciplina
    'listardisciplinas.php' => [0, 1, 2, 3],
    'listarDisciplinas.php' => [0, 1, 2, 3],
    'editaDisciplina.php' => [0, 1, 2, 3],

    //pasta aluno
    'listarAlunos.php' => [0, 1, 2, 3],
    'editaAluno.php' => [0, 1, 2, 3],

    //Relatótios
    'relatorioUsuario.php' => [0, 1],
    'relatorioProduto.php' => [0, 1, 3, 4],
    'relatorioFuncionario.php' => [0, 1, 4],
    'relatorioDisciplina.php' => [0, 1, 2, 3],
    'relatorioAluno.php' => [0, 1, 2, 3],
];

// Obtém o nome da página atual
$pagina_atual = basename($_SERVER['PHP_SELF']);

// Verifica se o usuário tem permissão para acessar a página atua
if (!in_array($nivel_usu, $permissoes[$pagina_atual])) {
    echo "Você não tem permissão para acessar esta página.";
    exit;
}

// Se o usuário estiver logado e tiver permissão, prossiga