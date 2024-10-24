<?php
function autorizar_v4($xml_assinado)
{
    require_once '../EmissorNFe/sped-nfe/vendor/autoload.php';

    $para_retornar = array(
        'xml' => '',
        'status' => 0,
        'obs' => ''
    );

    $configJson = gera_json();
    $ler = json_decode($configJson);
    $dt_validade = $ler->dt_validade;
    $certificado = base64_decode($ler->certificado);
    $senha = $ler->senha;

    $nfe = new NFePHP\NFe\Tools($configJson, NFePHP\Common\Certificate::readPfx($certificado, $senha));
    $nfe->model('55');

    try {
        $aResposta = array();
        $idLote = substr(str_replace(',', '', number_format(microtime(true) * 1000000, 0)), 0, 15);
        $indSinc = 1;

        if ($protocolo = $nfe->sefazEnviaLote([$xml_assinado], $idLote, $indSinc, $compactar = false, $aResposta)) {
            $xml_retorno = $protocolo;

            $stdCl = new NFePHP\NFe\Common\Standardize($xml_retorno);
            $std = $stdCl->toStd();
            $arr = $stdCl->toArray();
            $json = $stdCl->toJson();

            $cd_status = $std->protNFe->infProt->cStat;
            $obs = $std->protNFe->infProt->xMotivo;
            $_protocolo = $std->protNFe->infProt->nProt;
            $_chave = $std->protNFe->infProt->chNFe;

            if ($cd_status == '100') {
                echo "<h4>NFe autorizada!</h4>";

                $xml_para_retornar = atualiza_retorno($xml_assinado, $xml_retorno);

                file_put_contents('../EmissorNFe/xml/nfe_gerado.xml', $xml_para_retornar);
                file_put_contents('../EmissorNFe/xml/NFE' . $_chave . '.xml', $xml_para_retornar);

                $para_retornar['xml'] = $xml_para_retornar;
            } else {
                echo "<h4>$cd_status - $obs</h4>";
            }

            $para_retornar['status'] = $cd_status;
            $para_retornar['obs'] = $obs;
        }
    } catch (\Exception $e) {
        $para_retornar['obs'] = "Erro ao tentar se comunicar com a Sefaz: " . $e->getMessage();
        echo "<h4>" . $para_retornar['obs'] . "</h4>";
    }

    return $para_retornar;
}


function consulta_recibo($recibo)
{
	require_once '../EmissorNFe/sped-nfe/vendor/autoload.php';

	$configJson = gera_json();
	$ler = json_decode($configJson);
	$certificado = base64_decode($ler->certificado);
	$senha = $ler->senha;

	$nfe = new NFePHP\NFe\Tools($configJson, NFePHP\Common\Certificate::readPfx($certificado, $senha));
	$retorno = $nfe->sefazConsultaRecibo($recibo);
	$stdCl = new NFePHP\NFe\Common\Standardize($retorno);
	$std = $stdCl->toStd();

	$cd_status = $std->protNFe->infProt->cStat;
	$nm_status = $std->protNFe->infProt->xMotivo;

	$retorno_consulta = array(
		'cd_status' => $cd_status,
		'nm_status' => $nm_status,
		'retorno' => ($cd_status == '100') ? $retorno : null,
	);

	return $retorno_consulta;
}

function atualiza_retorno($xml_enviado, $protocolo)
{
	require_once '../EmissorNFe/sped-nfe/vendor/autoload.php';

	$xml_aprovado = NFePHP\NFe\Complements::toAuthorize($xml_enviado, $protocolo);
	return $xml_aprovado;
}
