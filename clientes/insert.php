<?php
session_start();
require_once '../check.php';
require_once '../conexao.php';
require_once '../buscaCep.php';

if($_POST['logradouro'] != '') {
    echo '<p>errou</p>';
} else {
    // Preenche os campos relacionados ao CEP

    $_SESSION['nome'] = $_POST['nome'];
    $_SESSION['cpf'] = $_POST['cpf'];
    $_SESSION['dtnasc'] = $_POST['dtnasc'];
    $_SESSION['sexo'] = $_POST['sexo'];
    $_SESSION['dddcli'] = $_POST['ddd'];
    $_SESSION['tel'] = $_POST['tel'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['sexo'] = $_POST['sexo'];

    $_SESSION['cep'] = $_POST['cep'];
    $resultado_busca = busca_cep($_SESSION['cep']);

    $_SESSION['tipo'] = $resultado_busca['tipo_logradouro'];
    $_SESSION['logradouro'] = $resultado_busca['logradouro'];
    $_SESSION['bairro'] = $resultado_busca['bairro'];
    $_SESSION['cidade'] = $resultado_busca['cidade'];
    $_SESSION['uf'] = $resultado_busca['uf'];
    header('location: cadastro.php');
}