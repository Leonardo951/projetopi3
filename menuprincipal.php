<?php
require_once 'check.php';
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
        <link href="css/menuprincipal.css" rel="stylesheet">

        <script src="js/ie-emulation-modes-warning.js"></script>

        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
    <section id="team" class="pb-5">
        <div class="container">
            <img src="img/cables.png" class="img-logo"/>
            <div class="row">
                <!-- Vendas -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">Vendas</h4>
                                        <p class="card-text">Controle de vendas</p>
                                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Estoque -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">Estoque</h4>
                                        <p class="card-text">Produtos disponiveis</p>
                                        <a href="produtos/produtos.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cliente -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">Clientes</h4>
                                        <p class="card-text">Gerenciar clientes</p>
                                        <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fornecedores -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">Fornecedores</h4>
                                        <p class="card-text">Gerenciar fornecedores</p>
                                        <a href="fornecedores/fornecedores.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- usuários -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">Usuários</h4>
                                        <p class="card-text">Gerenciar usuários</p>
                                        <a href="usuarios/usuarios.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sobre -->
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="image-flip" ontouchstart="this.classList.toggle('hover');">
                        <div class="mainflip">
                            <div class="frontside">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h4 class="card-title">Sair</h4>
                                        <p class="card-text">Sair da aplicação</p>
                                        <a href="logout.php" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </body>
</html>