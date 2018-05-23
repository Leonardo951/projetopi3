<?php

function sanear_valor($valor) {
// Pega apenas as partes numéricas
$partes = array_filter(preg_split("/([\D])/", $valor), 'strlen');

// Separa a fração do inteiro
$frac = count($partes) > 1 ? array_pop($partes) : "0";
$inteiro = implode("", $partes);

// Junta tudo, converte para ponto-flutuante e arredondanda
return round((float) ($inteiro . "." . $frac), 2);

}