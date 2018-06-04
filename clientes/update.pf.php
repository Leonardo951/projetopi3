<?php

require_once '../conexao.php';
require_once '../functions/limpar.php';
session_start();

$id = $_POST['id'];
$nome = ucwords(strtolower($_POST['nome']));
$cpf = limpa($_POST['cpf']);
$dtnasc = implode("-", array_reverse(explode("/", $_POST['dtnasc'])));
$sexo = $_POST['sexo'];
$ddd = $_POST['ddd'];
$tel = limpa($_POST['tel']);
$mail = strtolower($_POST['email']);

$cod = base64_encode($id);

$PDO = $conex;

$sql = "UPDATE tb_clientes_pf SET nome = :nome WHERE pk_clie_pf = :pk_clie_pf;
        UPDATE tb_clientes_pf SET cpf = :cpf WHERE pk_clie_pf = :pk_clie_pf;
        UPDATE tb_clientes_pf SET sexo = :sexo WHERE pk_clie_pf = :pk_clie_pf;
        UPDATE tb_clientes_pf SET email = :email WHERE pk_clie_pf = :pk_clie_pf;
        UPDATE tb_clientes_pf SET dt_nasc = :dt_nasc WHERE pk_clie_pf = :pk_clie_pf;
        UPDATE tb_clientes_pf SET telefone = :telefone WHERE pk_clie_pf = :pk_clie_pf;
        UPDATE tb_clientes_pf SET fk_ddd = :fk_ddd WHERE pk_clie_pf = :pk_clie_pf;";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':cpf', $cpf);
$stmt->bindParam('sexo', $sexo);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':dt_nasc', $dtnasc);
$stmt->bindParam(':telefone', $tel);
$stmt->bindParam(':fk_ddd', $ddd);
$stmt->bindParam(':pk_clie_pf', $id);

if ($stmt->execute()) {
    print_r($stmt->errorInfo());
    $cep = limpa($_POST['cep']);
    $logradouro = $_POST['logradouro'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $uf = $_POST['estado'];
    $compl = $_POST['compl'];
    $num = $_POST['numero'];

    $sql = "UPDATE tb_endereco SET logradouro = :logradouro WHERE fk_cli_pf = :fk_cli_pf;
            UPDATE tb_endereco SET cidade = :cidade WHERE fk_cli_pf = :fk_cli_pf;
            UPDATE tb_endereco SET bairro = :bairro WHERE fk_cli_pf = :fk_cli_pf;
            UPDATE tb_endereco SET uf = :uf WHERE fk_cli_pf = :fk_cli_pf;
            UPDATE tb_endereco SET numero = :numero WHERE fk_cli_pf = :fk_cli_pf;
            UPDATE tb_endereco SET complemento = :complemento WHERE fk_cli_pf = :fk_cli_pf;
            UPDATE tb_endereco SET cep = :cep WHERE fk_cli_pf = :fk_cli_pf;";
    $stmt = $conex->prepare($sql);
    $stmt->bindParam(':logradouro', $logradouro);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':bairro', $bairro);
    $stmt->bindParam(':uf', $uf);
    $stmt->bindParam(':numero', $num);
    $stmt->bindParam(':complemento', $compl);
    $stmt->bindParam(':cep', $cep);
    $stmt->bindParam(':fk_cli_pf', $id);
    if ($stmt->execute()) {
        $_SESSION['recado'] = 'editado';
        header('Location: viewer.pf.php?view=' . $cod . '');
    } else {
        $_SESSION['recado'] = 'erroend';
        header('Location: viewer.pf.php?view=' . $cod . '');
//        print_r($stmt->errorInfo());
    }
} else {
    $_SESSION['recado'] = 'erroedicao';
    header('Location: viewer.pf.php?view=' . $cod . '');
}