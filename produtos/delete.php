<?php

session_start();
include_once '../conexao.php';

$id = $_POST['id'];
$qntd = $_POST['qntd'];
echo $id;
if ($qntd == 0 ) {

    $PDO = $conex;

    $sql = "DELETE FROM tb_produto WHERE pk_prod = :pk_prod;";

    $stmt = $PDO->prepare($sql);

    $stmt->bindParam('pk_prod', $id);

    if ($stmt->execute()) {
        $_SESSION['recado'] = 'deletado';
        header('Location: produtos.php');

    } else {
        echo 'errado';
        $_SESSION['recado'] = 'nodelete';
        header('Location: produtos.php');
    }
}else {
    $_SESSION['recado'] = 'quantidade';
    header('Location: produtos.php');
}
