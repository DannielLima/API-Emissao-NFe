<?php
gera_json();
function gera_json()
{

  $certificado = file_get_contents('certificado_caninana.pfx');
  $certificado = base64_encode($certificado);
  $senha = '123456';
  $token_csc = '252C78C8-5E79-4691-B0F6-4891FB0DC338';
  $token_csc_id = '000001';
  $arr =  array(
    "tpAmb"     =>  '2',
    "razaosocial" =>  'SYSDATA INFORMATICA',
    "cnpj"      =>  '32727872000142',
    "siglaUF"   =>  'MA',
    "schemes"         =>  "PL_009_V4",
    "versao"          =>  "4.00",
    "tokenIBPT"   =>  '',
    "dt_validade" =>  '2022-04-12 10:37:53',
    "certificado" =>  $certificado,
    "senha"     =>  $senha,
    "CSC"         =>  $token_csc,
    "CSCid"       =>  $token_csc_id
  );


  $json = json_encode($arr);
  echo '<prev>';
  print_r($json);
  echo '<prev>';
  //return $json;
}
