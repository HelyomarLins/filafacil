<?php
session_start();
include_once('../../API/conexao.php');

$erro = 0;
$criador = $_SESSION['nome_usu'];
if ($_SESSION["logged_in"]) {
    $idCampo = $_SESSION["id_usu"];

    // Escapar a variável para evitar injeção de SQL
    $idCampo = mysqli_real_escape_string($conexao, $idCampo);

    // Consulta SQL para buscar todas as chamadas não atendidas do usuário logado
    $sql = "SELECT fc.*, cf.nome_fila 
            FROM filas_chamada fc
            INNER JOIN criarfila cf ON fc.id_fila_chamada = cf.id_criar_fila
            WHERE cf.id_usu = '$idCampo' AND fc.atendido = 'não'";

    $resultado = mysqli_query($conexao, $sql);

    // Inicializa um array na sessão para armazenar os IDs das filas
    $_SESSION['filas_ids'] = [];
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
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Verifica se há resultados
                if (mysqli_num_rows($resultado) > 0) {
                    // Loop para exibir cada fila na tabela
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . $row["nome_chamada"] . "</td>"; // Nome da chamada
                        echo "<td>" . $row["nome_fila"] . "</td>"; // Nome da fila
                        echo "<td>" . $row["posicao_chamada"] . "</td>"; // Posição da chamada
                        echo "<td>";
                        echo "<a href='#' class='edit' data-id='" . $row["id_chamada"] . "' onclick=\"loadContent('/Fila_Facil/system/usuario/accessFilaUsu.php?id_criar_fila=" . $row["id_fila_chamada"] . "')\">";
                        echo "<i class='bx bxs-pencil' data-toggle='tooltip' title='Editar'></i>";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";

                        // Armazenar os IDs das filas na sessão
                        $_SESSION['filas_ids'][] = $row['id_fila_chamada'];
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