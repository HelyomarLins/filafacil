<?php

// Usar o use para carregar classe através do Composer
use chillerlan\QRCode\{QRCode, QROptions};

// Incluir Composer
include_once('./vendor/autoload.php');

// Criar a variável com a URL para o QRCode
$data = 'https://celke.com.br/curso/curso-de-php';
//$data = 'http://localhost/celke/avaliar.php?loja=5';


// Instanciar a classe para enviar os parâmetros para o QRCode
$options = new QROptions([
    // Número da versão do código QRCode
    'version'      => 7,
    // escala da imagem 
    'scale'        => 4,
    // Alterar para base64
    'imageBase64'  => true,
]);

// Gerar QRCode: instanciar a classe QRCode e enviar os dados para o render gerar o QRCode
$qrcode = (new QRCode($options))->render($data);

// Conteúdo do cabeçalho
$cabecalho_pdf = "<div style='text-align: center; margin-bottom: 50px; '>";
$cabecalho_pdf .= "<img src='./imagens/celke.jpg' alt='Celke' width='20'>";
$cabecalho_pdf .= "<p style='text-align: center;'>Título do cabeçalho</p>";
$cabecalho_pdf .= "<p style='text-align: center;'>Subtítulo do cabeçalho</p>";
$cabecalho_pdf .= "</div>";

// Conteúdo do PDF
$conteudo_pdf = "<h1 style='font-size: 60px; text-align: center; padding-top: 180px;'>Acesse noso QRCode</h1>";
$conteudo_pdf .= "<div style='text-align: center;'><img src='$qrcode' width='200'></div>";
$conteudo_pdf .= "<h2 style='font-size: 60px; text-align: center; padding-top: 180px;'>Acesse nossa url//</h2>";
$conteudo_pdf .= "<div style='text-align: center;'></div>";
//echo $conteudo_pdf;

// Conteúdo do rodapé
$rodape_pdf = "<div style='text-align: center;'>Conteúdo do rodapé</div>";

// Instanciar a classe para gerar PDF
$mpdf = new \Mpdf\Mpdf();

// true desativa a validação de certificado para solicitações cURL, carregar a imagem
$mpdf->curlAllowUnsafeSslRequests = true;

// Atribuir o cabeçalho para o PDF
$mpdf->SetHTMLHeader($cabecalho_pdf);

// Atribuir o conteúdo para o PDF
$mpdf->WriteHTML($conteudo_pdf);

$mpdf->SetHTMLFooter($rodape_pdf);

// Imprimir PDF
$mpdf->Output();