<?php

include_once '../conexao.php';
session_start();

// resgata variáveis do formulário
$email = isset($_POST['email']) ? $_POST['email'] : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

$PDO = $conex;

$sql = "SELECT * FROM view_usuario WHERE email = :email AND senha = :senha";
$stmt = $PDO->prepare($sql);

$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $senha);

$stmt->execute();

$users = $stmt->fetch();

if (empty($users))
{
    $_SESSION['loginErro'] = "Usuário ou senha inválido!";
    header('Location: login.php');
} else {
    if(isset($_POST['active'])) {
        $_SESSION['online'] = true;
    } else {
        $_SESSION['online'] = false;
        $_SESSION["sessiontime"] = time() + 1200;
    };

    $_SESSION['user'] = base64_encode($users['perfil']);
    $_SESSION['coduser'] = base64_encode($users['pk_usuario']);
    $_SESSION['usuario'] = base64_encode($users['nome_usuario']);
    $_SESSION['recado'] = 'nada';

    header('Location: ../menuprincipal.php');
}