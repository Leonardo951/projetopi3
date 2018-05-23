<?php

session_start();
require_once '../check.php';
include_once '../conexao.php';
include_once '../converter.php';

$prod   = $_POST['prod'];
$preco = sanear_valor($_POST['preco']);
$cat = $_POST['cat'];

$sql = 'SELECT pk_categoria FROM tb_categoria WHERE categoria =  :categoria;';
$prepara = $conex->prepare($sql);
$prepara->bindParam(':categoria', $cat);
$prepara->execute();
while ($pk = $prepara->fetch()) {
    $pk_categoria = $pk['pk_categoria'];
};

$sql = "INSERT INTO tb_produto (nome_prod, preco, fk_categoria) VALUES (?,?,?);";
$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $prod);
$stmt->bindValue(2, $valor);
$stmt->bindValue(3, $pk_categoria);

if( $stmt->execute() ){
    $_SESSION['recado'] = 'adicionado';
    header('Location: produtos.php');
} else {
    $_SESSION['recado'] = 'erroadicao';
    header('Location: produtos.php');

}