<?php
require_once '../conexao.php';

$tipo = $_GET['tipo'];

if($tipo == 'forn'){
    $sql = 'SELECT nome, cnpj FROM tb_fornecedor;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['nome'];
        $json[] = $n['cnpj'];
    };
    $res = json_encode($json);
    echo $res;
}elseif($tipo == 'prod'){
    $sql = 'SELECT cod_prod, nome_prod FROM tb_produto;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['cod_prod'];
        $json[] = $n['nome_prod'];
    };
    $res = json_encode($json);
    echo $res;
}else{
    $erro = json_encode(array(
        "result" => false
    ));
    $nome = $_GET['nome'];
    $sql = 'SELECT marca, fk_categoria, pk_prod FROM tb_produto WHERE nome_prod = :nome_prod OR cod_prod = :cod_prod;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('nome_prod', $nome);
    $stmt->bindParam('cod_prod', $nome);
    if($stmt->execute()){
        $resultado = $stmt->fetch();
        $marca = $resultado['marca'];
        $pk_prod = $resultado['pk_prod'];
        $fk_cat = $resultado['fk_categoria'];

        $sql = 'SELECT categoria FROM tb_categoria WHERE pk_categoria = :pk;';
        $stmt = $conex->prepare($sql);
        $stmt->bindParam('pk', $fk_cat);
        if($stmt->execute()){
            $resultado = $stmt->fetch();
            $res = json_encode(array(
                "result" => true,
                "marca" => $marca,
                "prod" => $pk_prod,
                "cat" => $fk_cat,
                "categoria" => $resultado['categoria']
            ));
            echo $res;
        }else{
            echo $erro;
        }
    }else{
        echo $erro;
    }
}