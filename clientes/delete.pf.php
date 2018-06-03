<?php

session_start();
include_once '../conexao.php';

$id = $_POST['id'];

$PDO = $conex;

$sql="DELETE FROM tb_clientes_pf WHERE pk_clie_pf = :id";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ( $stmt->execute() ) {
    $_SESSION['recado'] = 'deletado';
    header('Location: clientes.php');

} else {
    $_SESSION['recado'] = 'nodelete';
    header('Location: clientes.php');

}
