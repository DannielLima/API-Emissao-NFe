<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

session_start();
$_SESSION['pdv_prn_global'] = array();

if (!file_exists('monta_xml.php') || !file_exists('assina_xml.php') || !file_exists('autorizar_v4.php') || !file_exists('danfe.php')) {
	die("Erro: Arquivo necessário não encontrado.");
}

include 'monta_xml.php';
include 'assina_xml.php';
include 'autorizar_v4.php';
include 'danfe.php';
include 'inserir_certificado.php';

$id_certificado = 1;
$xmlGerado = monta_xml();
if (!$xmlGerado || empty($xmlGerado)) {
	error_log("Erro ao montar o XML.");
	echo "Erro ao montar o XML.";
	exit;
}
echo "XML gerado com sucesso.<br>";

file_put_contents(__DIR__ . '/xml/nfe_gerado.xml', $xmlGerado);
echo "XML gerado salvo com sucesso em /xml/nfe_gerado.xml.<br>";
if (!$xmlGerado || empty($xmlGerado)) {
	error_log("Erro ao montar o XML.");
	echo "Erro ao montar o XML.";
	exit;
}
echo "XML gerado com sucesso.<br>";

$xmlAssinadoRetorno = assina_xml($xmlGerado, $id_certificado);
if (!isset($xmlAssinadoRetorno['xml']) || empty($xmlAssinadoRetorno['xml'])) {
	error_log("Erro ao assinar o XML: " . ($xmlAssinadoRetorno['obs'] ?? 'Desconhecido'));
	echo "Erro ao assinar o XML: " . ($xmlAssinadoRetorno['obs'] ?? 'Desconhecido');
	exit;
}
$xmlAssinado = $xmlAssinadoRetorno['xml'];
echo "XML assinado com sucesso.<br>";

$retornoAutorizacao = autorizar_v4($xmlAssinado);
if (!$retornoAutorizacao || $retornoAutorizacao['status'] != '100') {
	error_log("Erro na autorização: " . ($retornoAutorizacao['obs'] ?? 'Desconhecido'));
	echo "Erro na autorização: " . ($retornoAutorizacao['obs'] ?? 'Desconhecido');
	exit;
}
echo "NFe autorizada com sucesso.<br>";

if (!isset($retornoAutorizacao['xml']) || empty($retornoAutorizacao['xml'])) {
	error_log("Erro: XML autorizado não foi retornado.");
	echo "Erro: XML autorizado não foi retornado.";
	exit;
}

$xmlAutorizado = $retornoAutorizacao['xml'];
echo "XML autorizado recebido com sucesso.<br>";

danfe($xmlAutorizado);
echo "DANFE gerado com sucesso.";
