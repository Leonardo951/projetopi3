<?php

require_once '../check.php';
include_once '../conexao.php';
session_start();

$nome   = ucwords(strtolower($_POST['nome']));
$email  = strtolower($_POST['email']);
$rz  = ucwords(strtolower($_POST['razao_soc']));
$ddd = $_POST['ddd'];
$tel = $_POST['tel'];
$cnpj = $_POST['cnpj'];

$sql = "INSERT INTO tb_fornecedor (nome, email, razao_soc, cnpj, fk_ddd, telefone) VALUES (?,?,?,?,?,?);";

$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $nome);
$stmt->bindValue(2, $email);
$stmt->bindValue(3, $rz);
$stmt->bindValue(4, $cnpj);
$stmt->bindValue(5, $ddd);
$stmt->bindValue(6, $tel);

if( $stmt->execute() ){
    $_SESSION['recado'] = 'adicionado';
    header('Location: fornecedores.php');
} else {
    $_SESSION['recado'] = 'erroadicao';
    header('Location: fornecedores.php');

}