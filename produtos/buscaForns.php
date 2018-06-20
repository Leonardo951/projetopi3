<?php
require_once '../conexao.php';

$sql = 'SELECT nome, cnpj FROM tb_fornecedor;';
$stmt = $conex->prepare($sql);
$stmt->execute();
while ($n = $stmt->fetch()) {
    $json[] = $n['nome'];
    $json[] = $n['cnpj'];
};
$res = json_encode($json);
echo $res;