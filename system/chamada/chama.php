<?php
session_start();
include_once('../../API/conexao.php');

$erro = 0;

if ($_SESSION["logged_in"]) {
    $idCampo = $_SESSION["id_usu"];

    // Escapar a variável para evitar injeção de SQL
    $idCampo = mysqli_real_escape_string($conexao, $idCampo);

    // Ajustar a consulta para buscar na tabela correta e relacionar com usuário
    $sql = "SELECT fc.*, cf.nome_fila 
            FROM filas_chamada fc
            INNER JOIN criarfila cf ON fc.id_fila_chamada = cf.id_criar_fila
            WHERE cf.pessoa_idUsu = '$idCampo' AND fc.atendido = 'não'";

    $resultado = mysqli_query($conexao, $sql);


?>
    <!-- MONTAGEM DA TABELA -->
    <div class="container">
        <div class="table-title">
            <div class="row">
                <div class="col-sm d-flex align-items-center justify-content-between">
                    <h2>Lista de Chamadas</h2>
                    <a href="#" id="btnCadastro" class="open-modal btnCriar">
                        <i class='bx bxs-plus-circle'></i><span>Novo</span>
                    </a>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Nome da Chamada</th>
                    <th>Fila</th>
                    <th>Posição</th>
                </tr>
            </thead>
            <tbody id="chamadas-list">
                <?php
                // Verifica se há resultados
                if (mysqli_num_rows($resultado) > 0) {
                    // Loop para exibir cada fila na tabela
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $row["nome_chamada"] . "</td>";
                        echo "<td>" . $row["nome_fila"] . "</td>";
                        echo "<td>" . $row["posicao_chamada"] . "</td>"; // Exibindo a posição
                        echo "<td>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Exibir linha vazia se não houver resultados
                    echo "<tr>";
                    echo "<td colspan='4' class='text-center'>Nenhuma chamada encontrada.</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
    // Fechar a conexão com o banco de dados
    mysqli_close($conexao);
} else {
    echo "Usuário não está logado.";
}
?>