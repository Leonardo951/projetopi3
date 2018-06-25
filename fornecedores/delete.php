<?php

session_start();
include_once '../conexao.php';

$id = $_POST['id'];

$PDO = $conex;

$sql="DELETE FROM tb_fornecedor WHERE pk_fornecedor = :id";

$stmt = $PDO->prepare($sql);

$stmt->bindParam('id', $id);

if ( $stmt->execute() ) {
    $_SESSION['recado'] = 'deletado';
    header('Location: fornecedores.php');

} else {
    $_SESSION['recado'] = 'nodelete';
//    header('Location: fornecedores.php');
    echo $id;
}
