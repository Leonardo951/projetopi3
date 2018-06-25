<?php

session_start();
include_once '../conexao.php';

$id = $_POST['id'];

$PDO = $conex;

$sql="DELETE FROM tb_cliente_pj WHERE pk_cliente_pj = :id;
      DELETE FROM bt_endereco WHERE fk_cli_pj = :id;";

$stmt = $PDO->prepare($sql);

$stmt->bindParam(':id', $id, PDO::PARAM_INT);

if ( $stmt->execute() ) {
    $_SESSION['recado'] = 'deletado';
    header('Location: clientes.php');

} else {
    $_SESSION['recado'] = 'nodelete';
    header('Location: clientes.php');
}
