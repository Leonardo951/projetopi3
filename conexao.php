<?php

function getConn(){
    $dsn = 'mysql:host=localhost;dbname=bd_compra_venda';
    $user = 'teste';
    $senha = '12345678';

    //    Dados do servidor
//    $dsn = 'mysql:host=localhost;dbname=id6264713_bd_compra_venda';
//    $user = 'id6264713_senac';
//    $senha = 'projetoPI3';

    try {

        $con = new PDO($dsn, $user, $senha);

        return $con;

    } catch (Exception $ex) {
        echo "ERRO: " .$ex->getMessage();
    }
}

$conex = getConn();