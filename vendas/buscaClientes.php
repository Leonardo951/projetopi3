<?php
require_once '../conexao.php';

if($_GET['tipo'] == 'fisica'){
    $sql = 'SELECT nome, cpf FROM tb_clientes_pf;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['nome'];
        $json[] = $n['cpf'];
    };
    $res = json_encode($json);
    echo $res;
}elseif ($_GET['tipo'] == 'resp'){
    $sql = 'SELECT empresa, cnpj FROM tb_cliente_pj;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['empresa'];
        $json[] = $n['cnpj'];
    };
    $res = json_encode($json);
    echo $res;
}else{
    $sql = 'SELECT responsavel FROM tb_cliente_pj;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['responsavel'];
    };
    $res = json_encode($json);
    echo $res;
}