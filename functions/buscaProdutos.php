<?php

require_once '../conexao.php';

$cod_prod = $_GET['prod'];

$sql = 'SELECT * FROM view_produtos WHERE cod_prod = :cod_prod;';
$stmt = $conex->prepare($sql);
$stmt->bindParam(':cod_prod', $cod_prod);
if ($stmt->execute()) {
    $produto = $stmt->fetch();
    if(isset($produto['nome_prod'])){
        $nome = $produto['nome_prod'];
        $qntd = $produto['qntd_estoq'];
        $preco = $produto['preco'];

        echo json_encode(array(
            "result" => true,
            "nome" => $nome,
            "qntd" => $qntd,
            "preco" => $preco
        ));
    } else {
        echo json_encode(array(
            "result" => false,
            "message" => "   Código Inválido!"
        ));
    }
} else {
    echo json_encode(array(
        "result" => false,
        "message" => "   Erro inesperado!"
    ));
}