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
$mpdf->SetHTMLHeader('<div style="text-align: center; font-weight: bold;">Relatório de Disciplinas</div>');

// Corpo do PDF
$htmlCorpo = '
<h2>Tabela de Disciplinas</h2>
<table border="1" cellspacing="0" cellpadding="8" style="width: 100%; border-collapse: collapse;">
    <thead>
        <tr style="background-color: #f0f0f0;">
            <th>ID</th>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Carga Horária</th>
        </tr>
    </thead>
    <tbody>';

// Consulta ao banco de dados para obter os usuários
$sql = "SELECT * FROM disciplina";
$resultado = mysqli_query($conexao, $sql);

// Verifica se há resultados
if ($resultado->num_rows > 0) {
    // Loop pelos resultados e adiciona na tabela HTML
    while ($row = $resultado->fetch_assoc()) {
        $htmlCorpo .= '
        <tr>
            <td>' . $row["id_disc"] . '</td>
            <td>' . $row["nome_disc"] . '</td>
            <td>' . $row["sigla_disc"] . '</td>
            <td>' . $row["ch_disc"] . '</td>
        </tr>';
    }
} else {
    $htmlCorpo .= '<tr><td colspan="4">Nenhum disiciplina encontrado</td></tr>';
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
