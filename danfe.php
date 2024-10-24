<?php
// function danfe($xml)
// {
// 	require_once '../EmissorNFe/sped-nfe/vendor/autoload.php';

// 	$arquivo = "../EmissorNFe/pdf/nfe/NFE-" . $_SESSION['chave_nota'] . ".pdf";

// 	try {

// 		$danfe = new NFePHP\DA\NFe\Danfe($xml, 'R', 'A4', 'images/logo.jpg', 'I', '');
// 		$id = $danfe->montaDANFE();
// 		$pdf = $danfe->render();
// 		file_put_contents($arquivo, $pdf);
// 	} catch (InvalidArgumentException $e) {

// 		echo "Ocorreu um erro durante o processamento do DANF-e :" . $e->getMessage();
// 	}

// 	return;
// }

require 'vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

function danfe($xmlAssinado) {
    $xml = simplexml_load_string($xmlAssinado);
    $xml->registerXPathNamespace('nfe', 'http://www.portalfiscal.inf.br/nfe');

    $emitente = $xml->xpath('//nfe:emit/nfe:xNome')[0];
    $destinatario = $xml->xpath('//nfe:dest/nfe:xNome')[0];
    $valorTotal = $xml->xpath('//nfe:total/nfe:ICMSTot/nfe:vNF')[0];
    $chaveAcesso = $xml->xpath('//nfe:infProt/nfe:chNFe')[0];

    $html = "
    <html>
    <head>
        <style>
            body { font-family: DejaVu Sans, sans-serif; }
            .container { width: 100%; border: 1px solid #000; padding: 20px; }
            .header { text-align: center; font-size: 14px; }
            .content { margin-top: 20px; }
            .section { margin-bottom: 20px; }
            .section-title { font-weight: bold; font-size: 12px; }
            .info { margin-top: 5px; font-size: 10px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>DANFE - Documento Auxiliar da Nota Fiscal Eletrônica</h2>
            </div>
            <div class='content'>
                <div class='section'>
                    <div class='section-title'>Emitente</div>
                    <div class='info'>Nome: $emitente</div>
                </div>
                <div class='section'>
                    <div class='section-title'>Destinatário</div>
                    <div class='info'>Nome: $destinatario</div>
                </div>
                <div class='section'>
                    <div class='section-title'>Valor Total</div>
                    <div class='info'>R$ $valorTotal</div>
                </div>
                <div class='section'>
                    <div class='section-title'>Chave de Acesso</div>
                    <div class='info'>$chaveAcesso</div>
                </div>
            </div>
        </div>
    </body>
    </html>
    ";

    $options = new Options();
    $options->set('isRemoteEnabled', true);
    $dompdf = new Dompdf($options);

    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'portrait');

    $dompdf->render();

    $dompdf->stream('danfe.pdf', ['Attachment' => 0]);
}