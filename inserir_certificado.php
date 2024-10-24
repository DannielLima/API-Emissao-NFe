<?php

function inserir_certificado($razao_social, $cnpj, $caminho_certificado, $senha_certificado)
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=nome_do_banco', 'usuario', 'senha');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $caminho_certificado = __DIR__ . '/certificado_caninana.pfx';
        $certificado = file_get_contents($caminho_certificado);
        $certificado_base64 = base64_encode($certificado);

        $sql_verifica = "SELECT id FROM certificados WHERE cnpj = :cnpj";
        $stmt_verifica = $pdo->prepare($sql_verifica);
        $stmt_verifica->execute([':cnpj' => $cnpj]);

        if ($stmt_verifica->rowCount() > 0) {
            echo "Certificado já cadastrado para este CNPJ.";
            return;
        }

        $razao_social = "Caninana Ribeiro LTDA";
        $cnpj = "00.000.000/0000-00";
        $senha_certificado = "123456";
        $data_emissao = "2024-10-24";
        $data_validade = "2025-10-24"; 
        $emitido_por = "Autoridade Certificadora";

        $sql = "INSERT INTO certificados (razao_social, cnpj, certificado_base64, senha_certificado, data_emissao, data_validade, emitido_por, criado_em)
                VALUES (:razao_social, :cnpj, :certificado_base64, :senha_certificado, :data_emissao, :data_validade, :emitido_por, NOW())";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':razao_social' => $razao_social,
            ':cnpj' => $cnpj,
            ':certificado_base64' => $certificado_base64,
            ':senha_certificado' => $senha_certificado,
            ':data_emissao' => $data_emissao,
            ':data_validade' => $data_validade,
            ':emitido_por' => $emitido_por,
        ]);

        echo "Certificado inserido com sucesso!";
    } catch (PDOException $e) {
        echo "Erro ao inserir o certificado: " . $e->getMessage();
    }
}

function ler_certificado($id_certificado)
{
    try {
        $conn = new mysqli('localhost', 'root', '', 'nfe_certs');

        if ($conn->connect_error) {
            throw new Exception("Falha na conexão: " . $conn->connect_error);
        }

        $sql = "SELECT certificado_base64, senha_certificado FROM certificados WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_certificado);
        $stmt->execute();
        $stmt->bind_result($certificado_base64, $senha_certificado);
        $stmt->fetch();

        if (!$certificado_base64) {
            throw new Exception("Certificado não encontrado para o ID: $id_certificado");
        }

        $certificado = base64_decode($certificado_base64);

        $x509certdata = null;
        if (!openssl_pkcs12_read($certificado, $x509certdata, $senha_certificado)) {
            echo "<script>alert('O certificado não pode ser lido. Pode estar corrompido ou a senha está errada!');</script>";
            return false;
        }

        $certKEY = $x509certdata['pkey'] . "\r\n" . $x509certdata['cert'];
        $conteudo = $certKEY;
        $certinfo = openssl_x509_parse($conteudo, false);

        return array(
            'certificado' => $certificado,
            'certinfo' => $certinfo,
        );
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
        return false;
    }
}
?>
