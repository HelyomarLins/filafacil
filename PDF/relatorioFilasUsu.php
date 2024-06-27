<?php
// Carregar o Composer
require './vendor/autoload.php';

// Incluir conexão com BD
include_once('../API/conexao.php');

// Instanciar a classe para gerar PDF
$mpdf = new \Mpdf\Mpdf();

// Permitir solicitações cURL sem verificação de certificado SSL
$mpdf->curlAllowUnsafeSslRequests = true;

// Configurar o tamanho e a orientação do papel
//$mpdf->SetPageOrientation('P'); // Portrait

// Cabeçalho do PDF
$mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">Relatório de Usuários</div>');

// Corpo do PDF - Exemplo de tabela com dados de usuários
$htmlCorpo = '
<h2>Tabela de Usuários</h2>
<table border="1" cellspacing="0" cellpadding="8" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>E.mail</th>
            <th>Nível</th>
            <th>Ativo</th>
            <th>Data/Cadastro</th>
        </tr>
    </thead>
    <tbody>';

// Consulta ao banco de dados para obter os usuários
$sql = "SELECT * FROM criarfila";
$resultado = mysqli_query($conexao, $sql);

// Verifica se há resultados
if ($resultado->num_rows > 0) {
    // Loop pelos resultados e adiciona na tabela HTML
    while ($row = $resultado->fetch_assoc()) {
        $htmlCorpo .= '
        <tr>
            <td>' . $row["id_criar_fila"] . '</td>
            <td>' . $row["nome_fila"] . '</td>
            <td>' . $row["qtd_fila"] . '</td>
            <td>' . $row["data_criacao_fila"] . '</td>
            <td>' . $row["pessoa_idUsu"] . '</td>
            
        </tr>';
    }
} else {
    $htmlCorpo .= '<tr><td colspan="4">Nenhum usuário encontrado</td></tr>';
}

$htmlCorpo .= '
    </tbody>
</table>';

// Rodapé do PDF
$mpdf->SetHTMLFooter('<div style="text-align: center;">Sistema de Gerenciamento - ' . date('d/m/Y H:i') . '</div>');

// Escrever o conteúdo no PDF
$mpdf->WriteHTML($htmlCorpo);

// Gerar o PDF
$mpdf->Output();