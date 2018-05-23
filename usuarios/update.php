<?php

require_once '../conexao.php';
session_start();

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$perfil = $_POST['perfil'];

$PDO = $conex;

$sql = 'SELECT pk_perfil FROM tb_perfil WHERE perfil = :perfil;';
$prepara = $PDO->prepare($sql);
$prepara->bindParam(':perfil', $perfil);
$prepara->execute();
while ($pk = $prepara->fetch()) {
    $pk_perfil = $pk['pk_perfil'];
};

$sql = "UPDATE tb_usuario SET nome = :nome WHERE pk_usuario = :id;
        UPDATE tb_usuario SET email = :email WHERE pk_usuario = :id;
        UPDATE tb_usuario SET fk_perfil = :fk_perfil WHERE pk_usuario = :id";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':nome', $nome);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':fk_perfil', $pk_perfil);
$stmt->bindParam(':id', $id);

if ($stmt->execute()) {
    $_SESSION['recado'] = 'editado';
    header('Location: usuarios.php');
} else {
    $_SESSION['recado'] = 'erroedicao';
    header('Location: usuarios.php');
}