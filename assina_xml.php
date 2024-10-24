<?php
// function assina_xml($xml)
// {
//   error_reporting(E_ALL);
//   ini_set('display_errors', 'On');
//   require_once '../EmissorNFe/sped-nfe/vendor/autoload.php';

//   $retorno = array();
//   $agora = date("Y-m-d h:i:s");

//   $configJson    =  gera_json();
//   $ler       =  json_decode($configJson);
//   $dt_validade  =  $ler->dt_validade;
//   $certificado  =  base64_decode($ler->certificado);
//   $senha      =  $ler->senha;
//   $agora       =   date("Y-m-d H:i:s");

//   if ($dt_validade < $agora) {
//     echo "<script>alert('Certificado digital vencido!');</script>";
//   } else {
//     file_put_contents('../EmissorNFe/xml/NFE' . $_SESSION['chave_nota'] . '-antes_assinar.xml', $xml);

//     try {

//       $nfe = new NFePHP\NFe\Tools($configJson, NFePHP\Common\Certificate::readPfx($certificado, $senha));
//       $xml_assinado = $nfe->signNFe($xml);
//       file_put_contents('../EmissorNFe/xml/NFE-' . $_SESSION['chave_nota'] . '-assinado.xml', $xml_assinado);
//       $obs = 'Arquivo xml assinado e validado com sucesso!';
//     } catch (\Exception $e) {

//       $obs = $e->getMessage();
//       $xml_assinado  = '';
//     }
//   }

//   $retorno['obs'] = $obs;
//   $retorno['mensagem'] = $obs;
//   $retorno['xml'] = $xml_assinado;

//   return ($retorno);
// }


// function gera_json()
// {

//   $certificado = file_get_contents('../EmissorNFe/certificado.pfx');
//   $senha = '123456';
//   $token_csc = '252C78C8-5E79-4691-B0F6-4891FB0DC338';
//   $token_csc_id = '000001';
//   $ambiente = 2;
//   $arr =  array(
//     "tpAmb"     =>  $ambiente,
//     "razaosocial" =>  'SYSDATA INFORMATICA',
//     "cnpj"      =>  '32727872000142',
//     "siglaUF"   =>  'MA',
//     "schemes"   =>  "PL_009_V4",
//     "versao"    =>  "4.00",
//     "tokenIBPT"   =>  '',
//     "dt_validade" =>  '2022-04-12 10:37:53',
//     "certificado" =>  $certificado,
//     "senha"     =>  $senha,
//     "CSC"         =>  $token_csc,
//     "CSCid"       =>  $token_csc_id
//   );


//   $json = json_encode($arr);

//   return $json;
// }

function assina_xml($xml, $id_certificado)
{
    require_once '../EmissorNFe/sped-nfe/vendor/autoload.php';

    $cert_data = ler_certificado($id_certificado);
    if (!$cert_data) {
        return array('obs' => 'Erro ao ler o certificado.');
    }

    $certificado = $cert_data['certificado'];
    $senha = '123456';

    try {
        $nfe = new NFePHP\NFe\Tools(gera_json(), NFePHP\Common\Certificate::readPfx($certificado, $senha));
        $xml_assinado = $nfe->signNFe($xml);

        file_put_contents('../EmissorNFe/xml/NFE-' . $_SESSION['chave_nota'] . '-assinado.xml', $xml_assinado);
        $obs = 'Arquivo XML assinado e validado com sucesso!';
    } catch (\Exception $e) {
        $obs = 'Erro ao assinar XML: ' . $e->getMessage();
        $xml_assinado = '';
    }

    return array('obs' => $obs, 'xml' => $xml_assinado);
}

function gera_json()
{
    $certificado = file_get_contents('certificado_caninana.pfx');
    $senha = '123456';
    $token_csc = '252C78C8-5E79-4691-B0F6-4891FB0DC338';
    $token_csc_id = '000001';
    $ambiente = 2;

    $arr = array(
        "tpAmb" => $ambiente,
        "razaosocial" => 'SYSDATA INFORMATICA',
        "cnpj" => '32727872000142',
        "siglaUF" => 'MA',
        "schemes" => "PL_009_V4",
        "versao" => "4.00",
        "tokenIBPT" => '',
        "dt_validade" => '2025-04-12 10:37:53',
        "certificado" => $certificado,
        "senha" => $senha,
        "CSC" => $token_csc,
        "CSCid" => $token_csc_id
    );

    return json_encode($arr);
}
