<?php
session_start();
require_once '../conexao.php';

$pk_prod = $_POST['pk_prod'];
$fk_cat = $_POST['fk_cat'];
$valor = $_POST['valor'];
$qnt = $_POST['qnt'];
$fornecedor = $_POST['fornecedor'];

$sql = 'SELECT pk_fornecedor FROM tb_fornecedor WHERE nome = :nome;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('nome', $fornecedor);
//            Selecionando a pk do fornecedor
$stmt->execute();
$res = $stmt->fetch();
$pk_forn = $res['pk_fornecedor'];

$sql = 'SELECT * FROM tb_produto WHERE pk_prod = :pk_prod;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('pk_prod', $pk_prod);
//Selecionando os dados do produto comprado
$stmt->execute();

$res = $stmt->fetch();
$cod_prod = $res['cod_prod'];
$nome_prod = $res['nome_prod'];
$qntd_estoq = $res['qntd_estoq'];
$preco = $res['preco'];
$marca = $res['marca'];

$qt_est = $qnt + $qntd_estoq;
$sql = 'INSERT INTO tb_produto (fk_categoria, cod_prod, nome_prod, qntd_estoq, preco, marca) VALUES (?,?,?,?,?,?);';
$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $fk_cat);
$stmt->bindValue(2, $cod_prod);
$stmt->bindValue(3, $nome_prod);
$stmt->bindValue(4, $qt_est);
$stmt->bindValue(5, $preco);
$stmt->bindValue(6, $marca);
//                Inserindo os dados do produto novamente, com a quantidade atualizada e uma nova pk
if($stmt->execute()){
    $sql = 'DELETE FROM tb_produto WHERE pk_prod = :pk_prod;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('pk_prod', $pk_prod);
//    Deletando os dados do banco deste produto, visto que já estão em variaveis aqui no arquivo
    $stmt->execute();
}else{
    $_SESSION['recado'] = 'compraerro';
    header('location: produtos.php');
}

$sql = 'SELECT pk_prod FROM tb_produto WHERE cod_prod = :cod_prod;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('cod_prod', $cod_prod);
//        Selecionando  a nova pk criada para o produto
$stmt->execute();

$res = $stmt->fetch();
$pk_prod = $res['pk_prod'];
$sql = 'INSERT INTO tb_compras (fk_produto, fk_fornecedor, quantidade, vl_compra) VALUES (?,?,?,?);';
$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $pk_prod);
$stmt->bindValue(2, $pk_forn);
$stmt->bindValue(3, $qnt);
$stmt->bindValue(4, $valor);
if($stmt->execute()){
    $_SESSION['recado'] = 'compraadd';
    header('location: produtos.php');
}else{
    $_SESSION['recado'] = 'compraerro';
    header('location: produtos.php');
}
