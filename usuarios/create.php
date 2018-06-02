<?php

session_start();
require_once '../check.php';
include_once '../conexao.php';

$nome = ucwords(strtolower($_POST['nome']));
$email  = strtolower($_POST['email']);
$senha  = $_POST['senha'];
$perfil = $_POST['perfil'];

$sql = 'SELECT pk_perfil FROM tb_perfil WHERE perfil = :perfil;';
$prepara = $conex->prepare($sql);
$prepara->bindParam(':perfil', $perfil);
$prepara->execute();
while ($pk = $prepara->fetch()) {
    $pk_perfil = $pk['pk_perfil'];
};

$sql = "INSERT INTO tb_usuario (nome, email, senha, fk_perfil) VALUES (?,?,?,?)";

$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $nome);
$stmt->bindValue(2, $email);
$stmt->bindValue(3, $senha);
$stmt->bindValue(4, $pk_perfil);

if($stmt->execute()){
        $_SESSION['recado'] = 'adicionado';
        header('Location: usuarios.php');

    } else {
        $_SESSION['recado'] = 'erroadicao';
        header('Location: usuarios.php');

    }