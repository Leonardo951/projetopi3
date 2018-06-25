<?php

require_once '../conexao.php';
include_once '../converter.php';
session_start();

$id = $_POST['id'];
$nome   = ucwords(strtolower($_POST['nome']));
$email  = strtolower($_POST['email']);
$rz  = ucwords(strtolower($_POST['razao_soc']));
$ddd = $_POST['ddd'];
$tel = $_POST['tel'];
$cnpj = sanear_valor($_POST['cnpj']);


$PDO = $conex;

$sql = "UPDATE tb_fornecedor SET nome = :nome, razao_soc = :razao_soc, cnpj = :cnpj, email = :email, fk_ddd = :fk_ddd, telefone = :telefone WHERE pk_usuario = :id;";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':razao_soc', $rz);
$stmt->bindParam(':cnpj', $cnpj);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':fk_ddd', $ddd);
$stmt->bindParam(':telefone', $tel);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    $_SESSION['recado'] = 'editado';
    header('Location: forneedores.php');

} else {
    $_SESSION['recado'] = 'erroedicao';
    header('Location: fornecedores.php');

}