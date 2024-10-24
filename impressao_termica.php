<?php
require_once "../EmissorNFe/sped-nfe/vendor/autoload.php";

use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use NFePHP\POS\DanfcePos;

$printer_ip = '192.168.1.200';
$printer_porta = 9100;

try {
    $connector = new NetworkPrintConnector($printer_ip, $printer_porta);
} catch (\Exception $ex) {
    die('Não foi possível conectar com a impressora.');
}

$danfcepos = new DanfcePos($connector);

$xmlpath = '../EmissorNFe/xml/21211214355089000113650020000005171008080085.xml';
$danfcepos->loadNFCe($xmlpath);

$danfcepos->imprimir();

echo 'DANFCe impresso.';
