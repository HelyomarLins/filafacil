<?php
session_start();
include_once('../../API/conexao.php');

// Verifica se o usuário está logado
if (isset($_SESSION['nome_chamda']) && isset($_SESSION['tel_chamada'])) {
    $usuAccess = $_SESSION['nome_chamda'];
    $telAccess = $_SESSION["tel_chamada"];

    // Escapar as variáveis para evitar injeção de SQL
    $usuAccess = mysqli_real_escape_string($conexao, $usuAccess);
    $telAccess = mysqli_real_escape_string($conexao, $telAccess);

    $sql = "SELECT * FROM filas_chamda WHERE nome_chamada = '$usuAccess' AND tel_chamada = '$telAccess'";
    $resultado = mysqli_query($conexao, $sql);

    // Inicializa um array na sessão para armazenar os IDs das filas
    $_SESSION['filas_ids'] = [];
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
                <th>Fila</th>
                <th>Posição</th>
                <th>Acesso</th>
                <th>Atendido</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // Verifica se há resultados
                if (mysqli_num_rows($resultado) > 0) {
                    // Loop para exibir cada fila na tabela
                    while ($row = mysqli_fetch_assoc($resultado)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row["nome_fila_chamada"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["posicao_chamada"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["data_entrada"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["atendido"]) . "</td>";
                        echo "<td>";
                        echo "<a href='#' class='edit' data-id='"  . htmlspecialchars($row["id_criar_fila"]) . "' onclick=\"loadContent('/Fila_Facil/system/usuario/accessFilaUsu.php?id_criar_fila=" . htmlspecialchars($row["id_criar_fila"]) . "')\">";
                        echo "<i class='bx bxs-pencil' data-toggle='tooltip' title='Editar'></i>";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";

                        // Armazenar os IDs das filas na sessão
                        $_SESSION['filas_ids'][] = $row['id_criar_fila'];
                    }
                } else {
                    // Exibir linha vazia se não houver resultados
                    echo "<tr>";
                    echo "<td colspan='5' class='text-center'>Nenhuma fila encontrada.</td>";
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