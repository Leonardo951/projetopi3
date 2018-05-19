<?php

function getConn(){
    $dsn = 'mysql:host=localhost;dbname=bd_compra_venda';
    $user = 'teste';
    $senha = '12345678';

    try {

        $con = new PDO($dsn, $user, $senha);

        return $con;

    } catch (Exception $ex) {
        echo "ERRO: " .$ex->getMessage();
    }
}

$conex = getConn();