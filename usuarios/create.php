<?php

require_once '../check.php';
include_once '../conexao.php';
session_start();

$nome   = $_POST['nome'];
$email  = $_POST['email'];
$senha  = $_POST['senha'];
$perfil = $_POST['perfil'];

$sql = "INSERT INTO tb_usuario (nome, email, senha, perfil) VALUES (?,?,?,?)";

$stmt = $conex->prepare($sql);
$stmt->bindValue(1, $nome);
$stmt->bindValue(2, $email);
$stmt->bindValue(3, $senha);
$stmt->bindValue(4, $perfil);

if($stmt->execute()){
        $_SESSION['recado'] = 'adicionado';
        header('Location: usuarios.php');

    } else {
        $_SESSION['recado'] = 'erroadicao';
        header('Location: usuarios.php');

    }