<?php

require_once '../functions/check.php';
include_once '../conexao.php';
include_once '../converter.php';

$prod   = ucwords(strtolower($_POST['prod']));
$preco = sanear_valor($_POST['preco']);
$cat = $_POST['cat'];

$sql = 'SELECT pk_categoria FROM tb_categoria WHERE categoria =  :categoria;';
$prepara = $conex->prepare($sql);
$prepara->bindParam(':categoria', $cat);
$prepara->execute();
while ($pk = $prepara->fetch()) {
    $pk_categoria = $pk['pk_categoria'];
};

$c = 1;
while ($c < 1000) {
    if($cat == "Software") {
        $cod = rand(11111, 99999);
    }else{
        $cod = rand(111111, 999999);
    }
    $sql = "SELECT cod_prod FROM tb_produto WHERE cod_prod = :cod_prod;";
    $stmt = $conex->prepare($sql);
    $stmt->bindParam(':cod_prod', $cod);
    $stmt->execute();
    $codigos = $stmt->fetch();
    if (empty($codigos)){
        $cod_prod = $cod;
        break;
    }
    $c = $c+1;
}

$sql = "INSERT INTO tb_produto (nome_prod, preco, fk_categoria, cod_prod) VALUES (?,?,?,?);";
$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $prod);
$stmt->bindValue(2, $preco);
$stmt->bindValue(3, $pk_categoria);
$stmt->bindValue(4, $cod_prod);

if( $stmt->execute() ){
    $_SESSION['recado'] = 'adicionado';
    header('Location: produtos.php');
} else {
    $_SESSION['recado'] = 'erroadicao';
    header('Location: produtos.php');

}