<?php
// Carregar o Composer
require './vendor/autoload.php';

// Incluir conexão com BD
include_once('../API/conexao.php');

// Incluir verificação de login e permissões
include_once('../API/function/checkLogin.php');

// Instanciar a classe para gerar PDF
$mpdf = new \Mpdf\Mpdf();

// Permitir solicitações cURL sem verificação de certificado SSL
$mpdf->curlAllowUnsafeSslRequests = true;

// Configurar o tamanho e a orientação do papel
//$mpdf->SetPageOrientation('P'); // Portrait

// Cabeçalho do PDF
$mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">Relatório de Alunos</div>');

// Corpo do PDF
$htmlCorpo = '
<h2>Tabela de Alunos</h2>
<table border="1" cellspacing="0" cellpadding="8" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>Mat</th>
            <th>Nome</th>
            <th>Nascimento</th>
            <th>Sexo</th>
            <th>Nome do PAi</th>
            <th>Nome da Mãe</th>
            <th>Identidade</th>
            <th>CPF</th>
        </tr>
    </thead>
    <tbody>';

// Consulta ao banco de dados para obter os usuários
$sql = "SELECT * FROM alunos";
$resultado = mysqli_query($conexao, $sql);

// Verifica se há resultados
if ($resultado->num_rows > 0) {
    // Loop pelos resultados e adiciona na tabela HTML
    while ($row = $resultado->fetch_assoc()) {
        $htmlCorpo .= '
        <tr>
            <td>' . $row["mat_alu"] . '</td>
            <td>' . $row["nome_alu"] . '</td>
            <td>' . $row["dt_nasc"] . '</td>
            <td>' . $row["sexo_alu"] . '</td>
            <td>' . $row["nome_pai"] . '</td>
            <td>' . $row["nome_mae"] . '</td>
            <td>' . $row["rg_alu"] . '</td>
            <td>' . $row["cpf_alu"] . '</td>
        </tr>';
    }
} else {
    $htmlCorpo .= '<tr><td colspan="4">Nenhum aluno encontrado</td></tr>';
}

$htmlCorpo .= '
    </tbody>
</table>';

// Rodapé do PDF
$mpdf->SetHTMLFooter('<div style="text-align: center;">Sistema CRUD com PHP - ' . date('d/m/Y H:i') . '</div>');

// Escrever o conteúdo no PDF
$mpdf->WriteHTML($htmlCorpo);

// Gerar o PDF
$mpdf->Output();
