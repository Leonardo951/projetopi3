<?php
require_once '../conexao.php';

$tipo = $_GET['tipo'];

if($tipo == 'prod'){
    $sql = 'SELECT nome_prod, cod_prod FROM tb_produto;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['nome_prod'];
        $json[] = $n['cod_prod'];
    };
    $res = json_encode($json);
    echo $res;
}else{
    $prod = $_GET['prod'];
    $sql = 'SELECT nome_prod, cod_prod FROM tb_produto WHERE cod_prod = :cod OR nome_prod = :nome;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('cod', $prod);
    $stmt->bindParam('nome', $prod);
    $stmt->execute();
    $res = $stmt->fetch();
    $json = json_encode(array(
        "cod" => $res['cod_prod'],
        "nome" => $res['nome_prod']
    ));
    echo $json;
}