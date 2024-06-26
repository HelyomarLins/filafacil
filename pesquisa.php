<?php
// Arquivo de CONEXAO
session_start();
include_once('./API/conexao.php');

$erro = 0;
if (isset($_GET['id_criar_fila'])) {
    $id = $_GET['id_criar_fila'];
    echo "ID recebido: " . htmlspecialchars($id) . "<br>"; // Depuração

    $sql = "SELECT * FROM criarfila WHERE id_criar_fila = $id";
    $seleciona = mysqli_query($conexao, $sql);

    if ($seleciona) {
        $banco = mysqli_fetch_array($seleciona);
        // Armazenar os dados do banco em variáveis
        $nome =     $banco['nome_fila'];
        $email =    $banco['qtd_fila'];
        $abertura = $banco['data_inicio_fila'];
        $qtd =      $banco['qtd_fila'];
        $posicao =  $banco['posicao_fila'];

        // Depuração dos dados
        echo "Nome: " . htmlspecialchars($nome) . "<br>";
        echo "Quantidade: " . htmlspecialchars($qtd) . "<br>";
        echo "Data de Início: " . htmlspecialchars($abertura) . "<br>";
    } else {
        echo "Erro na consulta SQL: " . mysqli_error($conexao) . "<br>";
        $nome = $qtd = $abertura = $posicao = '';
    }
} else {
    $erro++;
    echo "ID não recebido<br>";
    $nome = $qtd = $abertura = $posicao = '';
}
?>
<div class="modal fade" id="modalEditarFila" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="cadLoginUsers" class="needs-validation box" novalidate>
                <div class="modal-header">
                    <img src="./assets/img/Screenshot_4.png" alt="">
                </div>
                <div class="modal-body">
                    <!--DADOS PARA EDITAR NA TABELA-->
                    <input type="hidden" name="tabela" value="criarfila">
                    <input type="hidden" id="pessoa_idUsu" name="pessoa_idUsu" value="<?php echo isset($_SESSION['id_usu']) ? $_SESSION['id_usu'] : ''; ?>">

                    <input type="text" name="nome_fila" placeholder="Nome" class="form-control" value="<?php echo htmlspecialchars($nome); ?>">
                    <div class="invalid-feedback">Preencha o nome da fila.</div>

                    <input type="number" name="qtd_fila" placeholder="Quantidade" class="form-control" value="<?php echo htmlspecialchars($qtd); ?>">
                    <div class="invalid-feedback">Preencha a quantidade da fila.</div>

                    <input type="date" name="data_inicio_fila" placeholder="Quantidade" class="form-control" value="<?php echo htmlspecialchars($abertura); ?>">
                    <div class="invalid-feedback">Preencha a data de início da fila.</div>

                    <input type="password" name="cod_acess_fila" placeholder="Codigo de acesso" class="form-control" autocomplete="current-password" value="<?php echo htmlspecialchars($nome); ?>">
                    <div class="invalid-feedback">Digite o código para acesso.</div>

                    <input id="btnCloseModal" type="submit" value="Cadastrar">
                </div>

                <div class="modal-footer">
                    <p class="text-muted">
                        <a href="#" onclick="logout()">SAIR<i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>