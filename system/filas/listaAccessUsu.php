<?php
session_start();
include_once('../../API/conexao.php');

// Verifica se as variáveis do POST estão setadas
if (isset($_POST['nome_chamada']) && isset($_POST['tel_chamada'])) {
    // Obtém os dados do formulário
    $usuAccess = $_POST['nome_chamada'];
    $telAccess = $_POST['tel_chamada'];

    // Escapar as variáveis para evitar injeção de SQL
    $usuAccess = mysqli_real_escape_string($conexao, $usuAccess);
    $telAccess = mysqli_real_escape_string($conexao, $telAccess);

    $sql = "SELECT * FROM filas_chamada WHERE nome_chamada = '$usuAccess' AND tel_chamada = '$telAccess'";
    $resultado = mysqli_query($conexao, $sql);

    // Verifica se houve erro na consulta
    if (!$resultado) {
        echo json_encode(['status' => false, 'msg' => 'Erro na consulta: ' . mysqli_error($conexao)]);
        exit();
    }

    // Inicializa um array na sessão para armazenar os IDs das filas
    $_SESSION['filas_ids'] = [];
    ob_start();
?>
    <!-- ## MONTAGEM DA TABELA ## -->
    <div class="container">
        <div class="table-title">
            <div class="row">
                <div class="col-sm d-flex align-items-center justify-content-between">
                    <h2>Listar <b>Filas</b></h2>
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
                        echo "<td>" . htmlspecialchars($row["nome_fila_chamada"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["posicao_chamada"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["data_entrada"]) . "</td>";
                        echo "<td>" . htmlspecialchars($row["atendido"]) . "</td>";
                        echo "<td>";

                        echo "<a href='#' class='delete open-modal btnDeleteAccess' data-id='" . $row["id_chamada"] . "' data-nome='" . $row["nome_fila_chamada"] . "'>";
                        echo "<i class='bx bxs-trash-alt' data-toggle='tooltip' title='Deletar'></i>";
                        echo "</a>";
                        echo "</td>";
                        echo "</tr>";

                        // Armazenar os IDs das filas na sessão
                        $_SESSION['filas_ids'][] = $row['id_chamada'];
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
    $html = ob_get_clean();
    echo json_encode(['status' => true, 'html' => $html]);
} else {
    echo json_encode(['status' => false, 'msg' => 'Dados do formulário não recebidos.']);
}

// Fechar a conexão com o banco de dados
mysqli_close($conexao);
?>