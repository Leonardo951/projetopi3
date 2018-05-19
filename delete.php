<?php

session_start();
include_once 'conexao.php';

$id = $_POST['id'];

$PDO = $conex;

$sql="DELETE FROM tb_usuario WHERE pk_usuario = :id";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

$stmt->execute();

$sql = 'SELECT pk_usuario FROM tb_usuario';
$prepara = $conex->prepare($sql);
$prepara->execute();

$count = $prepara->rowCount();

if ($count > 0) {
    $_SESSION['recado'] = 'deletado';
    header('Location: usuarios.php');

} else {
    $_SESSION['recado'] = 'nodelete';
    header('Location: usuarios.php');

}
