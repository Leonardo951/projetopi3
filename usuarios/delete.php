<?php

session_start();
include_once '../conexao.php';

$id = $_POST['id'];

$PDO = $conex;

$sql="DELETE FROM tb_usuario WHERE pk_usuario = :pk_usuario;";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':pk_usuario', $id, PDO::PARAM_INT);

if ( $stmt->execute() ) {
    $_SESSION['recado'] = 'deletado';
    header('Location: usuarios.php');

} else {
    $_SESSION['recado'] = 'nodelete';
    header('Location: usuarios.php');

}
