<?php
session_start();
date_default_timezone_set('America/Sao_Paulo');
require_once '../conexao.php';
?>
<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="Projeto PI3 da faculdade. Sistema de compra e venda">
        <meta name="author" content="Grupo 5 - SENAC">
        <link rel="icon" href="../img/favicon.png">

        <title>CABLES-Infomática</title>

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../css/login.css" rel="stylesheet">

        <script src="../js/ie-emulation-modes-warning.js"></script>
    </head>
    <body>
        <?php
        if(isset($_GET['id']) && isset($_GET['page'])) {
            $_SESSION['codigo'] = $_GET['id'];
            $_SESSION['date'] = $_GET['page'];

            $email = base64_decode($_SESSION['codigo']);
            $expirar = base64_decode($_SESSION['date']);
            $atual = date("Y-m-d H:i:s");
            if ($expirar < $atual) {
                echo '
                <div class="container">
                    <img id="profile-img" class="profile-img-card" src="../img/cables.png"/>
                    <div class="card card-container">';
                        if (isset($_SESSION['senhaErro'])) {
                            echo '
                            <div class="alert alert-danger" role="alert">';
                                echo $_SESSION['senhaErro'];
                                unset($_SESSION['senhaErro']);
                            echo '</div>';
                        } echo '
                        <form class="form-signin" method="POST" action="trocasenha.php">
                            <span id="reauth-email" class="reauth-email"></span>
                            <input type="password" id="inputEmail" name="novasenha" class="form-control" placeholder="Nova senha" required autofocus>
                            <input type="password" id="inputPassword" name="confirm" class="form-control"placeholder="Digite novamente" required>
                            <input type="hidden" name="id" value="true">
                            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Mudar senha</button>
                        </form>
                    </div>
                </div>';
            }else { ?>
            <div class="container">
                <img id="profile-img" class="profile-img-card" src="../img/cables.png"/>
                <div class="card card-container">
                    <br>
                    <div class="alert alert-danger text-center">
                        <strong>Desculpe! </strong>Este link expirou! <br><br>Por favor, solicite novamente <a href="relembre-me.php" class="esqueceu-senha">aqui</a>.
                    </div>
                </div>
            </div>
            <?php }
        }else{
            $_SESSION['loginErro'] = 'Você precisa estar logado.';
            header('location: ../login/login.php');
        }
        ?>
    </body>
</html>