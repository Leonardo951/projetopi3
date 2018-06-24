<?php
include_once '../conexao.php';
session_start();

$nome   = ucwords(strtolower($_POST['nome']));
$email  = strtolower($_POST['email']);
$rz  = ucwords(strtolower($_POST['razao_soc']));
$ddd = $_POST['ddd'];
$tel = $_POST['tel'];
$cnpj = $_POST['cnpj'];
$codigos = json_decode($_POST['codigos']);

$sql = "INSERT INTO tb_fornecedor (nome, email, razao_soc, cnpj, fk_ddd, telefone) VALUES (?,?,?,?,?,?);";

$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $nome);
$stmt->bindValue(2, $email);
$stmt->bindValue(3, $rz);
$stmt->bindValue(4, $cnpj);
$stmt->bindValue(5, $ddd);
$stmt->bindValue(6, $tel);

if( $stmt->execute() ){
    $sql = 'SELECT pk_fornecedor FROM tb_fornecedor WHERE cnpj = :cnpj;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('cnpj', $cnpj);
    $stmt->execute();
    $into = $stmt->fetch();
    $pk_forn = $into['pk_fornecedor'];

    $quantos = count($codigos);
    for ($i = 0; $i < $quantos; $i++){
        $sql = 'SELECT pk_prod FROM tb_produto WHERE cod_prod = :cod_prod;';
        $stmt = $conex->prepare($sql);
        $stmt->bindParam('cod_prod', $codigos[$i]);
        $stmt->execute();
        $into = $stmt->fetch();
//        array_push($pks, $into['pk_prod']);
        $sql = 'INSERT INTO tb_produtos_fornecidos (fk_prod, fk_fornecedor) VALUES (?,?);';
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $into['pk_prod']);
        $stmt->bindValue(2, $pk_forn);
        $stmt->execute();
    }

    $_SESSION['recado'] = 'adicionado';
    header('Location: fornecedores.php');
} else {
    $_SESSION['recado'] = 'erroadicao';
    header('Location: fornecedores.php');
}