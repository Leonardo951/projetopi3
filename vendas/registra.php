<?php
session_start();
require_once '../conexao.php';

$cpf = $_GET['cpf'];
$cnpj = $_GET['cnpj'];
$resp = $_GET['resp'];
$id_venda = base64_decode($_SESSION['venda']);

$sql = 'SELECT cod_venda, fk_usuario, vl_total, vl_desc, subtotal, qntd_prod FROM tb_venda WHERE pk_venda = :pk_venda;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('pk_venda', $id_venda);
$stmt->execute();
$into = $stmt->fetch();
$cod_venda = $into['cod_venda'];
$fk_usuario = $into['fk_usuario'];
$vl_total = $into['vl_total'];
$vl_desc = $into['vl_desc'];
$subtotal = $into['subtotal'];
$qntd_prod = $into['qntd_prod'];

$sql = 'DELETE FROM tb_venda WHERE pk_venda = :pk_venda;';
$stmt = $conex->prepare($sql);
$stmt->bindParam('pk_venda', $id_venda);
$stmt->execute();

if(isset($cpf)) {
    $sql = 'SELECT pk_clie_pf FROM tb_clientes_pf WHERE nome = :nome OR cpf = :cpf;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('nome', $cpf);
    $stmt->bindParam('cpf', $cpf);
    $stmt->execute();
    $into = $stmt->fetch();
    $id_fisica = $into['pk_clie_pf'];
    $id_jur = null;
}else{
    $sql = 'SELECT pk_cliente_pj FROM tb_cliente_pj WHERE responsavel = :resp;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('resp', $resp);
    $stmt->execute();
    $into = $stmt->fetch();
    $id_jur = $into['pk_cliente_pj'];
    $id_fisica = null;
}

$sql = 'INSERT INTO tb_venda(fk_clie_pf, fk_clie_pj, cod_venda, fk_usuario, vl_total, vl_desc, subtotal, qntd_prod) VALUES (?,?,?,?,?,?,?,?);';
$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $id_fisica);
$stmt->bindValue(2, $id_jur);
$stmt->bindValue(3, $cod_venda);
$stmt->bindValue(4, $fk_usuario);
$stmt->bindValue(5, $vl_total);
$stmt->bindValue(6, $vl_desc);
$stmt->bindValue(7, $subtotal);
$stmt->bindValue(8, $qntd_prod);
if($stmt->execute()){
    $sql = 'SELECT pk_venda FROM tb_venda WHERE cod_venda = :cod_venda;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('cod_venda', $cod_venda);
    $stmt->execute();
    $into = $stmt->fetch();
    $id_venda = $into['pk_venda'];
    $_SESSION['venda'] = base64_encode($id_venda);
    echo json_encode(array(
        "result" => true
    ));
}else{
    echo json_encode(array(
        "result" => false,
        "erro" => $stmt->errorInfo()
    ));
}