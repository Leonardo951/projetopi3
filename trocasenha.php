<?php
session_start();
require_once  'conexao.php';

if(isset($_POST['id']) && isset(($_SESSION['codigo']))) {

    $senha = $_POST['novasenha'];
    $confirmacao = $_POST['confirm'];
    $email = base64_decode($_SESSION['codigo']);

    if ($senha == $confirmacao) {
        $PDO = $conex;
        $sql = "UPDATE tb_usuario SET senha = :senha WHERE email = :email";
        $stmt = $PDO->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        if ($stmt->execute()) {
            $_SESSION['sucessoSenha'] = 'Senha alterada com sucesso!';
            header('location: login.php');
        } else {
            $_SESSION['senhaErro'] = 'Ocorreu um erro!';
            $cod = $_SESSION['codigo'];
            $dt = $_SESSION['date'];
            header('location: recuperar-senha.php?id=' . $cod . '&page=' . $dt . '');
        }

    } else {
        $_SESSION['senhaErro'] = 'As senhas informadas não são iguais';
        header('location: recuperar-senha.php?id=' . $cod . '&page=' . $dt . '');
    }
}else {
    $_SESSION['loginErro'] = 'Você precisa estar logado.';
    header('location: login.php');
}