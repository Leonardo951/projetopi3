<?php
require_once '../conexao.php';

    $sql = 'SELECT nome, cpf FROM tb_clientes_pf;';
    $stmt = $conex->prepare($sql);
    $stmt->execute();
    while ($n = $stmt->fetch()) {
        $json[] = $n['nome'];
        $json[] = $n['cpf'];
    };
$res = json_encode($json);
echo $res;