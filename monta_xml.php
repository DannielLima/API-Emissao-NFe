<?php

function monta_xml()
{

	date_default_timezone_set('America/Sao_Paulo');
	$todayd = date("Y-m-d");
	$todayt = date("H:i:s");
	echo '<br />';
	echo $todayd;
	echo '<br />';
	echo $todayt;
	//$venda_dados = $this->carrega_venda($_empresa_id); //Criar metodo de busca dos dados da venda
	$_data_emissao		= $todayd;
	$_hora_emissao		= $todayt;
	$_venda_id 			= '1'; //$venda_dados[0];
	$_cliente_id		= '1'; //$venda_dados[1]; 
	$_troco 			= '0.00'; //$venda_dados[2];
	$_total_mercadorias	= '0.10'; //$venda_dados[3]; 
	$_total_pago		= '0.10'; //$venda_dados[4];
	$_pg_dinheiro		= '0.10'; //$venda_dados[5];
	$_pg_credito		= '0.00'; //$venda_dados[6];
	$_pg_debito			= '0.00'; //$venda_dados[7];
	$_pg_outros			= '0.00'; //$venda_dados[8];
	$_tp_pagto			= '0'; //$venda_dados[9];
	$_tp_nf				= '1'; //$venda_dados[10];
	$_finalidade		= '1'; //$venda_dados[11];
	$_frete				= '1'; //$venda_dados[12];
	$_adicionais		= 'Teste NFe'; //$venda_dados[13];
	$_chave_devolucao	= ''; //$venda_dados[14];
	$_cfop				= '5405'; //$venda_dados[15];
	$_cfop_nome 		= 'Venda dentro do Estado';

	//$cliente_dados = $this->carrega_cliente($_cliente_id);
	$_cliente_cpf		= '60806735333'; //$cliente_dados[0];
	$_cliente_nome		= 'Lucas dos Santos Miranda'; //$cliente_dados[1];
	$_cliente_rua		= 'Rua x'; //$cliente_dados[2];
	$_cliente_numero	= '123'; //$cliente_dados[3];
	$_cliente_bairro	= 'Centro'; //$cliente_dados[4];
	$_cliente_cMun		= '2105302'; //$cliente_dados[5];
	$_cliente_uf		= '21'; //$cliente_dados[6];
	$_cliente_cep		= '65910010'; //$cliente_dados[7];
	$_cliente_fone		= '99984787036'; //$cliente_dados[8];
	$_cliente_indIEDest	= '9'; //$cliente_dados[9];
	$_cliente_IE		= ''; //$cliente_dados[10];
	$_cliente_xMun		= 'Imperatriz';
	$_cliente_xUf		= 'MA';


	$_dest_nome 		= trim($_cliente_nome);
	$_dest_cnpj 		= $_cliente_cpf;
	//$_dest_email		= trim($_cliente_email);



	$_emit_xNome 		= 'Empresa Teste';
	$_emit_fantasia 	= 'Teste';
	$_emit_cnpj 		= '32727872000142';
	$_emit_inscEstadual = '125905963';
	$_emit_crt 			= '3';
	$_emit_logradouro 	= 'rua Ceara';
	$_emit_numero 		= '424';
	$_emit_complemento 	= '1234';
	$_emit_bairro 		= 'Centro';
	$_emit_codMunicipio = '2105302';
	$_emit_nomeMunicipio = 'Imperatriz';
	$_emit_sigla_uf 	= 'MA';
	$_emit_codUF		= '21';
	$_emit_cep 			= '65901610';
	$_emit_codPais 		= '1058';
	$_emit_nomePais 	= 'BRASIL';
	$_emit_telefone 	= '99984787036';

	$_numero_nota 	= '21';
	$_semGTIN		= 'SEM GTIN';
	$var_cnf 		= $_numero_nota + 137;
	$var_cnf 		= str_pad($var_cnf, 8, "0", STR_PAD_LEFT);
	$_ide_cNF		= $var_cnf;
	$_ide_natOp 	= $_cfop_nome;
	$_ide_modNF 	= '55';
	$_ide_serie 	= '12';
	$_ide_numNF 	= $_numero_nota;
	$_ide_dtEmissao = $_data_emissao . 'T' . $_hora_emissao . '-03:00'; //Colocar fuso
	$_ide_dtSaiEnt 	= $_ide_dtEmissao;
	$_ide_hora 		= $_hora_emissao;
	$_ide_ambiente	= '2';
	$_ide_codMun 	= $_emit_codMunicipio;

	$_ide_tpNF 		= $_tp_nf;

	$_ide_tpImp 	= "1";
	$_ide_tpEmis 	= "1";
	$_ide_finalidade = $_finalidade;
	$_ide_indFinal	= '1';
	$_ide_procEmi 	= "0";
	$_ide_indPress	= "1";

	if ($_cliente_uf == $_emit_codUF) {
		$_ide_idDest 	= "1";
	} else {
		$_ide_idDest 	= "2";
	}



	$_ide_modal_frete = $_frete;

	$_ide_verProc 	= "2.2.5";
	$_ide_codUF		= '21';
	$_versaoNFe 	= "4.00";
	$_portal_nfe	= "http://www.portalfiscal.inf.br/nfe";

	$_prod_indTot 	= 1;

	$__porcento_imposto = 0.00 / 100;

	$_InfCpl 		= $_adicionais;

	$_chave_de_acesso =	$_ide_codUF .
		substr($_ide_dtEmissao, 2, 2) .
		substr($_ide_dtEmissao, 5, 2) .
		$_emit_cnpj .
		$_ide_modNF .
		str_pad($_ide_serie,   3, "0", STR_PAD_LEFT) .
		str_pad($_numero_nota, 9, "0", STR_PAD_LEFT) .
		$_ide_tpEmis .
		$var_cnf;

	$chave43 = $_chave_de_acesso;
	$soma_ponderada = 0;

	$multiplicadores = array(2, 3, 4, 5, 6, 7, 8, 9);
	$_i = 42;

	while ($_i >= 0) {
		for ($_m = 0; count($multiplicadores) > $_m && $_i >= 0; $_m++) {
			$soma_ponderada += $chave43[$_i] * $multiplicadores[$_m];
			$_i--;
		}
	}

	$resto = $soma_ponderada % 11;

	if ($resto == '0' || $resto == '1') {
		$cDV = 0;
	} else {
		$cDV = 11 - $resto;
	}

	$_ide_cDV = $cDV;

	$_chave_de_acesso .= $_ide_cDV;

	$_SESSION['chave_nota'] = $_chave_de_acesso;




	$dom = new DOMDocument();
	$dom->preserveWhiteSpace = false;
	$dom->formatOutput = false;
	$atrib_Id 			= $dom->createAttribute("Id");
	$atrib_Id->value = 'NFe' . $_chave_de_acesso;
	$atrib_versao 		= $dom->createAttribute("versao");
	$atrib_versao->value = $_versaoNFe;
	$atrib_xmlns 		= $dom->createAttribute("xmlns");
	$atrib_xmlns->value = $_portal_nfe;
	$atrib_root_versao	= $dom->createAttribute("versao");
	$atrib_root_versao->value = $_versaoNFe;
	$atrib_root_xmlns	= $dom->createAttribute("xmlns");
	$atrib_root_xmlns->value = $_portal_nfe;

	$root = $dom->createElement("nfeProc");
	$root->appendChild($atrib_root_xmlns);
	$root->appendChild($atrib_root_versao);

	$__NFe = $dom->createElement("NFe");
	$root->appendChild($__NFe);
	$__NFe->appendChild($atrib_xmlns);
	$__infNFe = $dom->createElement("infNFe");
	$__NFe->appendChild($__infNFe);
	$__infNFe->appendChild($atrib_versao);
	$__infNFe->appendChild($atrib_Id);

	$Ide = $dom->createElement("ide");
	$__infNFe->appendChild($Ide);

	$cUF 		= $dom->createElement("cUF", $_ide_codUF);
	$Ide->appendChild($cUF);
	$cNF 		= $dom->createElement("cNF", $_ide_cNF);
	$Ide->appendChild($cNF);
	$natOp 		= $dom->createElement("natOp", $_ide_natOp);
	$Ide->appendChild($natOp);
	$mod 		= $dom->createElement("mod", $_ide_modNF);
	$Ide->appendChild($mod);
	$serie 		= $dom->createElement("serie", $_ide_serie);
	$Ide->appendChild($serie);
	$nNF		= $dom->createElement("nNF", $_numero_nota);
	$Ide->appendChild($nNF);
	$dhEmi		= $dom->createElement("dhEmi", $_ide_dtEmissao);
	$Ide->appendChild($dhEmi);
	$tpNf 		= $dom->createElement("tpNF", $_ide_tpNF);
	$Ide->appendChild($tpNf);
	$idDest		= $dom->createElement("idDest", $_ide_idDest);
	$Ide->appendChild($idDest);
	$cMunFg		= $dom->createElement("cMunFG", $_ide_codMun);
	$Ide->appendChild($cMunFg);
	$tpImp		= $dom->createElement("tpImp", $_ide_tpImp);
	$Ide->appendChild($tpImp);
	$tpEmis		= $dom->createElement("tpEmis", $_ide_tpEmis);
	$Ide->appendChild($tpEmis);
	$cDV		= $dom->createElement("cDV", $_ide_cDV);
	$Ide->appendChild($cDV);
	$tpAmb 		= $dom->createElement("tpAmb", $_ide_ambiente);
	$Ide->appendChild($tpAmb);
	$finNFe		= $dom->createElement("finNFe", $_ide_finalidade);
	$Ide->appendChild($finNFe);
	$indFinal	= $dom->createElement("indFinal", $_ide_indFinal);
	$Ide->appendChild($indFinal);
	$indPres	= $dom->createElement("indPres", $_ide_indPress);
	$Ide->appendChild($indPres);
	$procEmi	= $dom->createElement("procEmi", $_ide_procEmi);
	$Ide->appendChild($procEmi);
	$verProc	= $dom->createElement("verProc", $_ide_verProc);
	$Ide->appendChild($verProc);

	if ($_ide_finalidade == 4) {
		$NFref 		= $dom->createElement("NFref");
		$Ide->appendChild($NFref);
		$refNFe 	= $dom->createElement("refNFe", $_chave_devolucao);
		$NFref->appendChild($refNFe);
	}



	$Emit = $dom->createElement("emit");
	$__infNFe->appendChild($Emit);

	$CNPJ_emit	= $dom->createElement("CNPJ", $_emit_cnpj);
	$Emit->appendChild($CNPJ_emit);
	$xNome	 	= $dom->createElement("xNome", $_emit_xNome);
	$Emit->appendChild($xNome);
	$xFant	 	= $dom->createElement("xFant", $_emit_fantasia);
	$Emit->appendChild($xFant);
	$enderEmit	= $dom->createElement("enderEmit");
	$Emit->appendChild($enderEmit);
	$xLgr	= $dom->createElement("xLgr", $_emit_logradouro);
	$enderEmit->appendChild($xLgr);
	$nro	= $dom->createElement("nro", $_emit_numero);
	$enderEmit->appendChild($nro);
	if (!empty($_emit_complemento)) {
		$xCpl	= $dom->createElement("xCpl", $_emit_complemento);
		$enderEmit->appendChild($xCpl);
	}
	$xBairro = $dom->createElement("xBairro", $_emit_bairro);
	$enderEmit->appendChild($xBairro);
	$cMun	= $dom->createElement("cMun", $_emit_codMunicipio);
	$enderEmit->appendChild($cMun);
	$xMun	= $dom->createElement("xMun", $_emit_nomeMunicipio);
	$enderEmit->appendChild($xMun);
	$UF	 	= $dom->createElement("UF", $_emit_sigla_uf);
	$enderEmit->appendChild($UF);
	$CEP	= $dom->createElement("CEP", $_emit_cep);
	$enderEmit->appendChild($CEP);
	$cPais	= $dom->createElement("cPais", $_emit_codPais);
	$enderEmit->appendChild($cPais);
	$xPais	= $dom->createElement("xPais", $_emit_nomePais);
	$enderEmit->appendChild($xPais);
	$_FONE	= $dom->createElement("fone", $_emit_telefone);
	$enderEmit->appendChild($_FONE);
	$IE	 	= $dom->createElement("IE", $_emit_inscEstadual);
	$Emit->appendChild($IE);
	$CRT	= $dom->createElement("CRT", $_emit_crt);
	$Emit->appendChild($CRT);

	if (!empty($_dest_cnpj)) {
		$dest = $dom->createElement("dest");
		$__infNFe->appendChild($dest);

		if (strlen($_dest_cnpj) > 11) {
			$CPF_dest = $dom->createElement("CNPJ", $_dest_cnpj);
			$dest->appendChild($CPF_dest);
		} else {
			$CPF_dest = $dom->createElement("CPF", $_dest_cnpj);
			$dest->appendChild($CPF_dest);
		}

		if (!empty($_dest_nome)) {
			if ($_ide_ambiente == '1') {
				$xNome_dest	= $dom->createElement("xNome", $_dest_nome);
			} else {
				$xNome_dest	= $dom->createElement("xNome", "NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL");
			}
			$dest->appendChild($xNome_dest);
		}
		$enderdest 			= $dom->createElement("enderDest");
		$dest->appendChild($enderdest);
		$x_dest_logradouro	= $dom->createElement("xLgr", $_cliente_rua);
		$enderdest->appendChild($x_dest_logradouro);
		$x_dest_numero		= $dom->createElement("nro", $_cliente_numero);
		$enderdest->appendChild($x_dest_numero);
		$x_dest_bairro		= $dom->createElement("xBairro", $_cliente_bairro);
		$enderdest->appendChild($x_dest_bairro);
		$x_dest_cidade		= $dom->createElement("cMun", $_cliente_cMun);
		$enderdest->appendChild($x_dest_cidade);
		$x_dest_cidade		= $dom->createElement("xMun", $_cliente_xMun);
		$enderdest->appendChild($x_dest_cidade);
		$x_dest_uf			= $dom->createElement("UF", $_cliente_xUf);
		$enderdest->appendChild($x_dest_uf);
		$x_cep_dest			= $dom->createElement("CEP", $_cliente_cep);
		$enderdest->appendChild($x_cep_dest);
		$x_dest_pais		= $dom->createElement("cPais", "1058");
		$enderdest->appendChild($x_dest_pais);
		$x_dest_nomePais	= $dom->createElement("xPais", "BRASIL");
		$enderdest->appendChild($x_dest_nomePais);
		$x_dest_telefone	= $dom->createElement("fone", $_cliente_fone);
		$enderdest->appendChild($x_dest_telefone);


		$indIEDest 			= $dom->createElement("indIEDest", $_cliente_indIEDest);
		$dest->appendChild($indIEDest);

		if (!empty($_dest_email)) {
			$dest_dest_email = $dom->createElement("email", $_dest_email);
			$dest->appendChild($dest_dest_email);
		}
	}

	if ($_ide_ambiente == 2) {
		$_prod_nome = 'NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
	} else {
		$_prod_nome = trim('Produto Teste');
	}
	$_prod_ncm 			= '18069000';
	$_prod_cfop			= $_cfop;
	$_prod_und 			= 'UN';
	$_prod_qtde 		= '1.0000';
	$_prod_vlr_unitario = '1.00';
	$_prod_vlr_total 	= '1.00';
	$_icms_origem 		= '0';
	$_icms_cst 			= '500';
	$_pis_cst 			= '04';
	$_cofins_cst 		= '04';
	$_prod_cest 		= '0301100';

	$_soma_produtos = 0;
	$_tot_tributos_incidentes = 0;
	$_soma_produtos += $_prod_vlr_total;



	$_prod_vlr_unitario_edt = number_format($_prod_vlr_unitario, 2, '.', '');
	$_prod_vlr_total_edt 	= number_format($_prod_vlr_total, 2, '.', '');

	$_tributos_incidentes = $_prod_vlr_total * $__porcento_imposto;
	$_tributos_incidentes = round($_tributos_incidentes, 2);
	$_tributos_incidentes = number_format($_tributos_incidentes, 2, '.', '');
	$_tot_tributos_incidentes += $_tributos_incidentes;

	$detItem = $dom->createElement("det");
	$__infNFe->appendChild($detItem);
	$atrib_nItem = $dom->createAttribute("nItem");
	$atrib_nItem->value = '1'; //$iprod+1;//Identificador do item da nota
	$detItem->appendChild($atrib_nItem);

	$prod = $dom->createElement("prod");
	$detItem->appendChild($prod);
	$cProd		= $dom->createElement("cProd", '1');
	$prod->appendChild($cProd);
	$cEAN		= $dom->createElement("cEAN", $_semGTIN);
	$prod->appendChild($cEAN);
	$xProd		= $dom->createElement("xProd", $_prod_nome);
	$prod->appendChild($xProd);
	$NCM		= $dom->createElement("NCM", $_prod_ncm);
	$prod->appendChild($NCM);
	$CEST		= $dom->createElement("CEST", $_prod_cest);
	$prod->appendChild($CEST);
	$CFOP		= $dom->createElement("CFOP", $_prod_cfop);
	$prod->appendChild($CFOP);
	$uCOM		= $dom->createElement("uCom", $_prod_und);
	$prod->appendChild($uCOM);
	$qCOM		= $dom->createElement("qCom", $_prod_qtde);
	$prod->appendChild($qCOM);
	$vUnCom		= $dom->createElement("vUnCom", $_prod_vlr_unitario_edt);
	$prod->appendChild($vUnCom);
	$vProd		= $dom->createElement("vProd", $_prod_vlr_total_edt);
	$prod->appendChild($vProd);
	$cEANTrib	= $dom->createElement("cEANTrib", $_semGTIN);
	$prod->appendChild($cEANTrib);
	$uTrib		= $dom->createElement("uTrib", $_prod_und);
	$prod->appendChild($uTrib);
	$qTrib		= $dom->createElement("qTrib", $_prod_qtde);
	$prod->appendChild($qTrib);
	$vUnTrib	= $dom->createElement("vUnTrib", $_prod_vlr_unitario_edt);
	$prod->appendChild($vUnTrib);
	$indTot		= $dom->createElement("indTot", $_prod_indTot);
	$prod->appendChild($indTot);
	$imposto = $dom->createElement("imposto");
	$detItem->appendChild($imposto);
	$vTotTrib	= $dom->createElement("vTotTrib", $_tributos_incidentes);
	$imposto->appendChild($vTotTrib);
	$ICMS		= $dom->createElement("ICMS");
	$imposto->appendChild($ICMS);



	if ($_icms_cst == 102 || $_icms_cst == 103 || $_icms_cst == 300 || $_icms_cst == 400) {
		$ICMS_CST = $dom->createElement("ICMSSN102");
		$ICMS->appendChild($ICMS_CST);
		$icms_orig	= $dom->createElement("orig", $_icms_origem);
		$ICMS_CST->appendChild($icms_orig);
		$icms_cst	= $dom->createElement("CSOSN", $_icms_cst);
		$ICMS_CST->appendChild($icms_cst);
	}

	if ($_icms_cst == 500) {
		$ICMS_CST = $dom->createElement("ICMS60");
		$ICMS->appendChild($ICMS_CST);
		$icms_orig	= $dom->createElement("orig", $_icms_origem);
		$ICMS_CST->appendChild($icms_orig);
		$icms_cst	= $dom->createElement("CST", "60");
		$ICMS_CST->appendChild($icms_cst);
	}




	$PIS = $dom->createElement("PIS");
	$imposto->appendChild($PIS);
	$PISNT = $dom->createElement("PISNT");
	$PIS->appendChild($PISNT);
	$pis_cst	= $dom->createElement("CST", $_pis_cst);
	$PISNT->appendChild($pis_cst);

	$COFINS = $dom->createElement("COFINS");
	$imposto->appendChild($COFINS);
	$COFINSNT		= $dom->createElement("COFINSNT");
	$COFINS->appendChild($COFINSNT);
	$cofins_cst	= $dom->createElement("CST", $_cofins_cst);
	$COFINSNT->appendChild($cofins_cst);


	$_soma_produtos_edt = $_soma_produtos;
	//nmgp_Form_Num_Val($_soma_produtos_edt, '', '.', 2, 'S', '1', '');	

	$_zerado = '0.00';
	$total = $dom->createElement("total");
	$__infNFe->appendChild($total);
	$ICMStot = $dom->createElement("ICMSTot");
	$total->appendChild($ICMStot);

	$vBC_ttlnfe		= $dom->createElement("vBC", $_zerado);
	$ICMStot->appendChild($vBC_ttlnfe);
	$vICMS_ttlnfe	= $dom->createElement("vICMS", $_zerado);
	$ICMStot->appendChild($vICMS_ttlnfe);
	$vICMSDesen		= $dom->createElement("vICMSDeson", $_zerado);
	$ICMStot->appendChild($vICMSDesen);

	$vFCP			= $dom->createElement("vFCP", $_zerado);
	$ICMStot->appendChild($vFCP);

	$vBCST_ttlnfe	= $dom->createElement("vBCST", $_zerado);
	$ICMStot->appendChild($vBCST_ttlnfe);
	$vST_ttlnfe		= $dom->createElement("vST", $_zerado);
	$ICMStot->appendChild($vST_ttlnfe);

	$vFCPST			= $dom->createElement("vFCPST", $_zerado);
	$ICMStot->appendChild($vFCPST);
	$vFCPSTRet		= $dom->createElement("vFCPSTRet", $_zerado);
	$ICMStot->appendChild($vFCPSTRet);

	$vProd_ttlnfe	= $dom->createElement("vProd", $_soma_produtos_edt);
	$ICMStot->appendChild($vProd_ttlnfe);
	$vFrete_ttlnfe	= $dom->createElement("vFrete", $_zerado);
	$ICMStot->appendChild($vFrete_ttlnfe);
	$vSeg_ttlnfe	= $dom->createElement("vSeg", $_zerado);
	$ICMStot->appendChild($vSeg_ttlnfe);
	$vDesc_ttlnfe	= $dom->createElement("vDesc", $_zerado);
	$ICMStot->appendChild($vDesc_ttlnfe);
	$vII_ttlnfe		= $dom->createElement("vII", $_zerado);
	$ICMStot->appendChild($vII_ttlnfe);
	$vIPI_ttlnfe	= $dom->createElement("vIPI", $_zerado);
	$ICMStot->appendChild($vIPI_ttlnfe);
	$vIPIDevol_ttlnfe = $dom->createElement("vIPIDevol", $_zerado);
	$ICMStot->appendChild($vIPIDevol_ttlnfe);
	$vPIS_ttlnfe	= $dom->createElement("vPIS", $_zerado);
	$ICMStot->appendChild($vPIS_ttlnfe);
	$vCOFINS_ttlnfe	= $dom->createElement("vCOFINS", $_zerado);
	$ICMStot->appendChild($vCOFINS_ttlnfe);
	$vOutro			= $dom->createElement("vOutro", $_zerado);
	$ICMStot->appendChild($vOutro);
	$vNF			= $dom->createElement("vNF", $_soma_produtos_edt);
	$ICMStot->appendChild($vNF);
	$vTotTrib		= $dom->createElement("vTotTrib", $_tot_tributos_incidentes);
	$ICMStot->appendChild($vTotTrib);


	$transp	 	= $dom->createElement("transp");
	$__infNFe->appendChild($transp);
	$modFrete	= $dom->createElement("modFrete", $_ide_modal_frete);
	$transp->appendChild($modFrete);


	$_tpIntegra = 2;

	$pag = $dom->createElement("pag");
	$__infNFe->appendChild($pag);
	if ($_ide_finalidade == 4) {
		$detPag = $dom->createElement("detPag");
		$pag->appendChild($detPag);
		$tPag90 = $dom->createElement("tPag", "90");
		$detPag->appendChild($tPag90);
		$vPag90 = $dom->createElement("vPag", "0.00");
		$detPag->appendChild($vPag90);
	} else {

		if ($_total_mercadorias > 0) {
			$detPag = $dom->createElement("detPag");
			$pag->appendChild($detPag);
			$tPag01 = $dom->createElement("tPag", "01");
			$detPag->appendChild($tPag01);
			//nmgp_Form_Num_Val($_total_mercadorias, '', '.', 2, 'S', '1', '');		
			$vPag01 = $dom->createElement("vPag", $_total_mercadorias);
			$detPag->appendChild($vPag01);
		}
	}







	if (!empty($_InfAdFisco) or !empty($_InfCpl)) {
		$infAdic = $dom->createElement("infAdic");
		$__infNFe->appendChild($infAdic);
		if (!empty($_InfAdFisco)) {
			$infAdFisco	= $dom->createElement("infAdFisco", $_InfAdFisco);
			$infAdic->appendChild($infAdFisco);
		}
		if (!empty($_InfCpl)) {
			$infCpl	= $dom->createElement("infCpl", $_InfCpl);
			$infAdic->appendChild($infCpl);
		}
	}


	$dom->appendChild($__NFe);

	$_xml_conteudo = $dom->saveXML();

	$local = '../EmissorNFe/nfe_gerado.xml';
	$dom->save($local);


	return $_xml_conteudo;
}
