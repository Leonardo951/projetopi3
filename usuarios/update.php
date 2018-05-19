<?php

require_once '../conexao.php';
session_start();

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$perfil = $_POST['perfil'];


$PDO = $conex;

$sql = "UPDATE tb_usuario SET nome = :nome WHERE pk_usuario = :id;
        UPDATE tb_usuario SET email = :email WHERE pk_usuario = :id;
        UPDATE tb_usuario SET perfil = :perfil WHERE pk_usuario = :id";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':perfil', $perfil);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    $_SESSION['recado'] = 'editado';
    header('Location: usuarios.php');

} else {
    $_SESSION['recado'] = 'erroedicao';
    header('Location: usuarios.php');

}