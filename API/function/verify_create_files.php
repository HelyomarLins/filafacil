<!-- Esta função [verifica se o usuáruio que está cadastrando a fila realmente exixte na tabela
 usuário. Checando o seu id_usu que já existe e seu e-mail que é unico na tabela usuario.
-->
<?php
function verifyUsers($email, $id)
{
    // Torna a variável $conexao, definida no arquivo conexao.php, acessível dentro desta função.
    global $conexao;

    /* - Prepara as queries para evitar SQL injection - */

    // Utiliza placeholders (?) para os valores que serão inseridos posteriormente.
    $sql_email = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE email_usu = ?");
    $sql_id = $conexao->prepare("SELECT COUNT(*) FROM usuario WHERE id_usu = ?");

    /* - Executa a query para o email - */
    // Associa o valor do parâmetro $email ao placeholder da query $sql_email.
    $sql_email->bind_param("s", $email);

    // Executa a query preparada.
    $sql_email->execute();

    // Obtém o resultado da query.
    $sql_email->store_result();
    $sql_email->bind_result($resultado_email);
    $sql_email->fetch();

    /* - Executa a query para o nome de usuário - */
    $sql_id->bind_param("s", $id);

    // Executa a query preparada.
    $sql_id->execute();

    // Obtém o resultado da query.
    $sql_id->store_result();
    $sql_id->bind_result($resultado_id);
    $sql_id->fetch();

    // Fecha as statements
    $sql_email->close();
    $sql_id->close();

    // Retorna um array com os resultados.
    return array(
        'email_exist' => $resultado_email > 0,
        'nome_exist' => $resultado_id > 0
    );
}