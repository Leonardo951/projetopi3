<?php
session_start();
?>
<!DOCTYPE html>

<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="Projeto PI3 da faculdade. Sistema de compra e venda">
    <meta name="author" content="Grupo 5 - SENAC">
    <link rel="icon" href="img/favicon.png">

    <title>CABLES-Infomática</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">

    <script src="js/ie-emulation-modes-warning.js"></script>
</head>
<body>
<div class="container">

    <img id="profile-img" class="profile-img-card" src="img/cables.png" />

    <div class="card card-container">

        <?php
        if(isset($_SESSION['loginErro'])) {
            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION['loginErro'];
            echo '<button class="close" data-dismiss="alert">x</button>';
            unset($_SESSION['loginErro']);
            echo '</div>';
        }
        if(isset($_SESSION['sucessoSenha'])) {
            echo '<div class="alert alert-success" role="alert">';
            echo $_SESSION['sucessoSenha'];
            echo '<button class="close" data-dismiss="alert">x</button>';
            unset($_SESSION['sucessoSenha']);
            echo '</div>';
        }
        if(isset($_SESSION['expirado'])) {
            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION['expirado'];
            echo '<button class="close" data-dismiss="alert">x</button>';
            session_unset();
            echo '</div>';
        }
        unset($_SESSION['codigo']);
        unset($_SESSION['date']);
        ?>

        <form class="form-signin" method="POST" action="validalogin.php">
            <span id="reauth-email" class="reauth-email"></span>

            <input type="email" id="inputEmail" name="email" class="form-control" placeholder="E-mail" required autofocus>
            <input type="password" id="inputPassword" name="senha" class="form-control" placeholder="Senha" required>

            <div id="relembre" class="checkbox">
                <label>
                    <input type="checkbox" value="lembre-me" name="active"> Lembre-me
                </label>
            </div>
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar</button>
        </form>

        <a href="relembre-me.php" class="esqueceu-senha">
            Esqueceu sua senha?
        </a>
    </div>
</div>
</body>
</html>