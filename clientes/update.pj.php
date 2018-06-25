<?php

require_once '../functions/limpar.php';
require_once '../conexao.php';
session_start();

$id = $_POST['id'];
$empresa = ucwords(strtolower($_POST['empresa']));
$razao_soc = ucwords(strtolower($_POST['razao_soc']));
$resp = ucwords(strtolower($_POST['resp']));
$cnpj = limpa($_POST['cnpj']);
$ddd = $_POST['ddd'];
$tel = limpa($_POST['tel']);
$mail = strtolower($_POST['email']);

$cod = base64_encode($id);

$PDO = $conex;

$sql = "UPDATE tb_cliente_pj SET empresa = :empresa WHERE pk_cliente_pj = :id;
        UPDATE tb_cliente_pj SET razao_soc = :razao_soc WHERE pk_cliente_pj = :id;
        UPDATE tb_cliente_pj SET responsavel = :responsavel WHERE pk_cliente_pj = :id;
        UPDATE tb_cliente_pj SET cnpj = :cnpj WHERE pk_cliente_pj = :id;
        UPDATE tb_cliente_pj SET email = :email WHERE pk_cliente_pj = :id;
        UPDATE tb_cliente_pj SET telefone = :telefone WHERE pk_cliente_pj = :id;
        UPDATE tb_cliente_pj SET fk_ddd = :fk_ddd WHERE pk_cliente_pj = :id;";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':empresa', $empresa);
$stmt->bindParam(':razao_soc', $razao_soc);
$stmt->bindParam('responsavel', $resp);
$stmt->bindParam(':cnpj', $cnpj);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':telefone', $tel);
$stmt->bindParam(':fk_ddd', $ddd);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    $cep = limpa($_POST['cep']);
    $logradouro = $_POST['logradouro'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $uf = $_POST['estado'];
    if (isset($_POST['compl'])) {
        $compl = $_POST['compl'];
    } else {
        $compl = 'null';
    }
    if (isset($_POST['numero'])) {
        $num = $_POST['numero'];
    } else {
        $num = 'null';
    }
        $sql = "UPDATE tb_endereco SET logradouro = :logradouro WHERE fk_cli_pj = :id;
                UPDATE tb_endereco SET cidade = :cidade WHERE fk_cli_pj = :id;
                UPDATE tb_endereco SET bairro = :bairro WHERE fk_cli_pj = :id;
                UPDATE tb_endereco SET uf = :uf WHERE fk_cli_pj = :id;
                UPDATE tb_endereco SET numero = :numero WHERE fk_cli_pj = :id;
                UPDATE tb_endereco SET complemento = :complemento WHERE fk_cli_pj = :id;
                UPDATE tb_endereco SET cep = :cep WHERE fk_cli_pj = :id;";
        $stmt = $conex->prepare($sql);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':bairro', $bairro);
        $stmt->bindParam(':uf', $uf);
        $stmt->bindParam(':numero', $num);
        $stmt->bindParam(':complemento', $compl);
        $stmt->bindParam(':cep', $cep);
        $stmt->bindParam(':id', $id);

$stmt->execute();;
        $_SESSION['recado'] = 'editado';
        header('Location: viewer.pj.php?view=' . $cod . '');

//    } else {
//        $_SESSION['recado'] = 'erroend';
//        header('Location: viewer.pj.php?view=' . $cod . '');

//    }
} else  {
    $_SESSION['recado'] = 'erroedicao';
    header('Location: viewer.pj.php?view=' . $cod . '');
}