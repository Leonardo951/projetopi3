<?php
session_start();
require_once '../conexao.php';
date_default_timezone_set('America/Sao_Paulo');

$total = $_POST['total'];
$desc = $_POST['descd'];
$descp = $_POST['descp'] ;
$subtotal = $_POST['subtotal'] ;
$_SESSION['itens'] = $_POST['itens'];
$_SESSION['quantidades'] = $_POST['qntd_prod'];
$qntd_prod = $_POST['qntd_tot'];
$cod_user = base64_decode($_SESSION['coduser']);

if($desc == 0){
    if($descp == 0){
        $desconto = 0;
    }else{
        $desconto = ($subtotal/100)*$descp;
    }
}else{
    $desconto = $desc;
}

$c = 0;
while ($c < 1000) {
    $codigo_venda = rand(11111111, 99999999);
    $sql = "SELECT cod_venda FROM tb_venda WHERE cod_venda = :cod_venda;";
    $stmt = $conex->prepare($sql);
    $stmt->bindParam(':cod_venda', $codigo_venda);
    $stmt->execute();
    $verifica = $stmt->fetch();
    if (empty($verifica)){
        break;
    }
    $c = $c+1;
}
$_SESSION['cod_venda'] = $codigo_venda;
$dt_hr = new DateTime();
$result = $dt_hr->format('Y-m-d H:i:s');

$sql = 'INSERT INTO tb_venda (cod_venda, fk_usuario, vl_total, vl_desc, subtotal, qntd_prod, dt_hr_venda) VALUES (?,?,?,?,?,?,?);';
$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $codigo_venda);
$stmt->bindValue(2, $cod_user);
$stmt->bindValue(3, $total);
$stmt->bindValue(4, $desconto);
$stmt->bindValue(5, $subtotal);
$stmt->bindValue(6, $qntd_prod);
$stmt->bindValue(7, $result);
if($stmt->execute()){
    $sql = 'SELECT pk_venda FROM tb_venda WHERE cod_venda = :cod_venda;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam(':cod_venda', $codigo_venda);
    $stmt->execute();
    $pk = $stmt->fetch();
    $_SESSION['venda'] = base64_encode($pk['pk_venda']);
    header('location: pagamento.php?venda='. $_SESSION['venda'] .'');
}else{
    $_SESSION['recado'] = 'errovenda';
}
