<?php
session_start();
require_once '../conexao.php';

$cod_venda = $_POST['venda'];

$sql = 'SELECT pk_venda FROM tb_venda WHERE cod_venda = :cod_venda;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('cod_venda',$cod_venda);
$stmt->execute();
$into = $stmt->fetch();
$pk_venda = $into['pk_venda'];

$sql = 'DELETE FROM tb_venda WHERE pk_venda = :pk_venda;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('pk_venda',$pk_venda);
if($stmt->execute()){
    $sql = 'DELETE FROM tb_prod_vendidos WHERE pk_venda = :pk_venda;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('fk_venda',$pk_venda);
    if($stmt->execute()){
        header('location: relVendas.php');
    }else{
        $_SESSION['recado'] = 'erroexclui';
        header('location: viewer.php?venda='. $cod_venda .'');
    }
}else{
    $_SESSION['recado'] = 'erroexclui';
    header('location: viewer.php?venda='. $cod_venda .'');
}