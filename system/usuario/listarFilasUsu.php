<?php
session_start();
include_once('../../API/conexao.php');

$erro = 0;
$criador =  $_SESSION['nome_usu'];
if ($_SESSION["logged_in"]) {
    $idCampo = $_SESSION["id_usu"];

    // Escapar a variável para evitar injeção de SQL
    $idCampo = mysqli_real_escape_string($conexao, $idCampo);

    $sql = "SELECT * FROM criarfila WHERE pessoa_idUsu = '$idCampo'";
    $resultado = mysqli_query($conexao, $sql);

?>
<!-- ## MONTAGEM DA TABELA ## -->
<div class="container">
    <div class="table-title">
        <div class="row">
            <div class="col-sm d-flex align-items-center justify-content-between">
                <h2>Criar <b>Filas</b></h2>
                <a href="#" id="btnCadastro" class="open-modal btnCriar">
                    <i class='bx bxs-plus-circle'></i><span>Criar</span>
                </a>
            </div>
        </div>
    </div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Vagas</th>
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
                        echo "<td>" . $row["nome_fila"] . "</td>";
                        echo "<td>" . $row["qtd_fila"] . "</td>";
                        echo "<td>" . $row["posicao_fila"] . "</td>"; // Exibindo a posição
                        echo "<td>";
                        echo "<a href='#' class='edit open-modal btnCriar' data-id='" . $row["id_criar_fila"] . "' onclick=\"loadAccess('/Fila_Facil/system/filas/accessFila1.php?id_criar_fila=" . $row["id_criar_fila"] . "')\">";
                        echo "<i class='bx bxs-pencil' data-toggle='tooltip' title='Acessar'></i>";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    // Exibir linha vazia se não houver resultados
                    echo "<tr>";
                    echo "<td colspan='4' class='text-center'>Nenhuma fila encontrada.</td>";
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