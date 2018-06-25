<?php

session_start();
require_once '../conexao.php';
include_once '../converter.php';

$id = $_POST['id'];
$prod = ucwords(strtolower($_POST['prod']));
$preco = sanear_valor($_POST['preco']);
$marca = ucwords(strtolower($_POST['marca']));
$categoria = $_POST['cat'];

$PDO = $conex;

$sql = 'SELECT pk_categoria FROM tb_categoria WHERE categoria = :categoria;';
$prepara = $PDO->prepare($sql);
$prepara->bindParam(':categoria', $categoria);
$prepara->execute();
$pk = $prepara->fetch();
$pk_categoria = $pk['pk_categoria'];

$sql = "UPDATE tb_produto SET nome_prod = :nome_prod, preco = :preco, marca = :marca, fk_categoria = :fk_categoria WHERE pk_prod = :pk_produto;";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':nome_prod', $prod);
$stmt->bindParam(':preco', $preco);
$stmt->bindParam(':marca', $marca);
$stmt->bindParam(':fk_categoria', $pk_categoria);
$stmt->bindParam(':pk_produto', $id);

if ($stmt->execute()) {
    $_SESSION['recado'] = 'editado';
    header('Location: produtos.php');
} else {
    $_SESSION['recado'] = 'erroedicao';
    header('Location: produtos.php');
}