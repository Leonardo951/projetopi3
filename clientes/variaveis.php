<?php

if(isset($_SESSION['cpf'])) {
    $cpf = $_SESSION['cpf'];
    unset($_SESSION['cpf']);
}
if(isset($_SESSION['email'])) {
    $mail = $_SESSION['email'];
    unset($_SESSION['email']);
}
if(isset($_SESSION['logradouro'])) {
    $logradouro = $_SESSION['logradouro'];
    unset($_SESSION['logradouro']);
}
if(isset($_SESSION['nome'])) {
    $nome = $_SESSION['nome'];
    unset($_SESSION['nome']);
}
if(isset($_SESSION['uf'])) {
    $uf = $_SESSION['uf'];
    unset($_SESSION['uf']);
}
if(isset($_SESSION['bairro'])) {
    $bairro = $_SESSION['bairro'];
    unset($_SESSION['bairro']);
}
if(isset($_SESSION['cidade'])) {
    $cidade = $_SESSION['cidade'];
    unset($_SESSION['cidade']);
}
if(isset($_SESSION['tipo'])) {
    $tipo = $_SESSION['tipo'];
    unset($_SESSION['tipo']);
}
if(isset($_SESSION['cep'])) {
    $cep = $_SESSION['cep'];
    unset($_SESSION['cep']);
}
if(isset($_SESSION['dddcli'])) {
    $ddd = $_SESSION['dddcli'];
    unset($_SESSION['dddcli']);
}
if(isset($_SESSION['tel'])) {
    $tel = $_SESSION['tel'];
    unset($_SESSION['tel']);
}
if(isset($_SESSION['sexo'])) {
    $sexo = $_SESSION['sexo'];
    unset($_SESSION['sexo']);
}
if(isset($_SESSION['dtnasc'])) {
    $dtnasc = $_SESSION['dtnasc'];
    unset($_SESSION['dtnasc']);
}