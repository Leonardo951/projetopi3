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
    <link rel="icon" href="../img/favicon.png">

    <title>CABLES-Infomática</title>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/relembre-me.css" rel="stylesheet">

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <script src="../js/ie-emulation-modes-warning.js" type="text/javascript"></script>
    <script src="../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="type/javascript"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>

<div class="containers">
    <img id="profile-img" class="recuper_img" src="../img/cables.png" />

    <div class="cards cards-containers">
        <?php
        if(isset($_SESSION['recuper'])) {
            echo '<div class="alert alert-danger" role="alert">';
            echo $_SESSION['recuper'];
            unset($_SESSION['recuper']);
            echo '</div>';
        };
        ?>
        <form class="form-recuper" action="recuperar.php" method="POST">
            <span id="valid-email" class="valid-email"></span>

            <input type="email" id="inputEmail" name="email" class="form-controls" placeholder="E-mail" required autofocus>

            <button class="btn_rec btn-lg btn-primary btn-block btn-recuper" type="submit">Enviar</button>
        </form>

        <a href="../login/login.php" class="btn-retorn">
            Retornar ao login
        </a>
    </div>
</div>
</body>
</html>