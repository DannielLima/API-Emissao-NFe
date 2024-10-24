<?php
if (isset($_SESSION['chave_nota'])) {
	$arquivo = "../EmissorNFe/pdf/nfe/NFE-" . $_SESSION['chave_nota'] . ".pdf";
	header('Content-Type: application/pdf');
	echo file_get_contents($arquivo);
} else {
	echo "
		<script>
			alert('Nota não encontrada!');
		</script>
	";
}
