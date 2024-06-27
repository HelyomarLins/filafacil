<?php
// Arquivo de conexão com o banco de dados
session_start();
include_once('../../API/conexao.php');

$erro = 0;
if (isset($_GET['id_criar_fila'])) {
    $id = $_GET['id_criar_fila'];

    $sql = "SELECT * FROM criarfila WHERE id_criar_fila = $id";
    $result = mysqli_query($conexao, $sql);

    if ($result) {
        $banco = mysqli_fetch_array($result);

        // Armazenar os dados do banco em variáveis
        $criador =  $banco['pessoa_idUsu'];
        $nome =     $banco['nome_fila'];
        $abertura = $banco['data_inicio_fila'];
        $qtd =      $banco['qtd_fila'];
        $posicao =  $banco['posicao_fila'];
        $codAccess =  $banco['cod_acess_fila'];
    } else {
        $erro++;
    }
} else {
    $erro++;
}

mysqli_close($conexao);
?>

<!-- HTML edição -->
<div class="container">
    <form id="createFilesUser" class="form" name="form" method="POST" onsubmit="createUpdateFiles(this, '/Fila_Facil/API/access_1.php'); return false;">


        <div class="modal-header">
            <h4 class="modal-title">Editar Fila</h4>
        </div>
        <!--DADOS PARA EDITAR NA TABELA-->
        <input type="hidden" name="tabela" value="criarfila">
        <input type="hidden" id="pessoa_idUsu" name="pessoa_idUsu" value="<?php echo isset($_SESSION['id_usu']) ? $_SESSION['id_usu'] : ''; ?>">
        <!-- Dados da Fila -->
        <input type="hidden" class="form-control" id="id_criar_fila" name="id_criar_fila" value="<?php echo $id ?>">

        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" id="pessoa_idUsu" name="pessoa_idUsu" value="<?php echo $criador ?>" readonly>
            </div>
            <div class="col-md-6">
                <label for="nome_fila" class="form-label">Fila</label>
                <input type="text" class="form-control" id="nome_fila" name="nome_fila" value="<?php echo $nome ?>" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <label for="qtd_fila" class="form-label">Quantidade</label>
                <input type="text" class="form-control" id="qtd_fila" name="qtd_fila" value="<?php echo $qtd ?>">
            </div>
            <div class="col-md-6">
                <label for="data_inicio_fila" class="form-label">Data de Início</label>
                <input type="date" class="form-control" id="data_inicio_fila" name="data_inicio_fila" value="<?php echo $abertura ?>">
            </div>
        </div>

        <!-- Dados do Acesso -->
        <div class="row">
            <div class="col-md-6">
                <label for="cod_acess_fila" class="form-label">Código de Acesso</label>
                <input type="password" class="form-control" id="cod_acess_fila" name="cod_acess_fila" value="<?php echo $codAccess ?>" required>
            </div>
            <div class="col-md-6">
                <label for="posicao_fila" class="form-label">Última Posição</label>
                <input type="text" class="form-control" id="posicao_fila" name="posicao_fila" value="<?php echo $posicao ?>" readonly>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-end">
                <hr>
                <input type="submit" class="btn btn-warning">Editar Fila</input>
                <input type="button" class="btn btn-secondary" onclick="logout()">Voltar</input>
            </div>
        </div>
    </form>
</div>