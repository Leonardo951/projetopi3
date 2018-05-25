<?php

function busca_cep($cep){
    $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
    if(!$resultado){
        $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
    }
    parse_str($resultado, $retorno);
    return $retorno;
}