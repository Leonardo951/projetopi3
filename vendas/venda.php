<?php
require_once '../functions/check.php';
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
    <link href="../css/venda.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <script src="../js/ie-emulation-modes-warning.js" type="text/javascript"></script>
    <script src="../js/jquery.inputmask.bundle.min.js" type="text/javascript"></script>
    <script src="../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="type/javascript"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
<div class="container">
    <div class="row">
        <a href="../menuprincipal.php">
            <img src="../img/cables.png/" class="img-logo-usuario"/>
        </a>
        <a href="../menuprincipal.php" class="btn btn-success-retorn btn_ini">
            <span><i class="fa fa-arrow-circle-left"></i> Voltar ao menu</span>
        </a>
        <a href="#addEmployeeModal" class="btn btn-success btn_ini" data-toggle="modal">
            <i class="material-icons">&#xE147;</i>
            <span>Novo usuário</span>
        </a>
        <div class="col-sm-6">
            <?php
            if ($_SESSION['recado'] == 'deletado') {?>
                <div class="alert alert-success">
                    <strong>Excluído! </strong>O usuário foi removido com sucesso!
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php } elseif($_SESSION['recado'] == 'nodelete') {?>
                <div class="alert alert-danger">
                    <strong>Algo deu errado. </strong>Ocorreu um erro ao excluir o usuário.
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php } elseif($_SESSION['recado'] == 'adicionado') {?>
                <div class="alert alert-success">
                    <strong>Adicionado! </strong>O usuário foi adicionado com sucesso!
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php } elseif($_SESSION['recado'] == 'erroadicao') {?>
                <div class="alert alert-warning">
                    <strong>Algo deu errado. </strong>Ocorreu um erro ao adicionar o usuário!
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php } elseif($_SESSION['recado'] == 'editado') {?>
                <div class="alert alert-success">
                    <strong>Modificado! </strong>As informações foram alteradas com sucesso!
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php } elseif($_SESSION['recado'] == 'erroedicao') {?>
                <div class="alert alert-danger">
                    <strong>Algo deu errado. </strong>Ocorreu um erro ao modificar as informações do usuário!
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php }
            $_SESSION['recado'] = 'vazio';
            ?>
        </div>
<!--        <div class="col-sm-12 col-md-10 col-md-offset-1">-->
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>Produtos</th>
                    <th>Quantidade</th>
                    <th class="text-center">Preço</th>
                    <th class="text-center">Total</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <td>
                    <div class="input-group div-input">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                        <input id="busca_prod" class="form-control" autofocus placeholder="Digite o código do produto..." type="search" title="Digite o código e aperte enter para pesquisar" onchange="buscaProd()">
                    </div>
                    <p class="text-warning" id="alert"><i class="material-icons">&#xe002;</i><small id="text"></small></p>
                </td>
                <tr id="exe">
                    <td class="col-sm-8 col-md-6" id="primeira">
                        <div class="media">
                            <div class="pull-left"> <img class="media-object img" src="../img/products.png"> </div>
                            <div>
                                <h5 class="media-heading" id="nome">Nome do produto<small class="media-heading" id="codigo"> [codigo]</small></h5>
                                <h6 class="media-heading" id="marca">Marca</h6>
                                <h6 class="media-heading" id="categoria">Categoria</h6>
                            </div>
                        </div>
                    </td>
                    <td class="col-sm-1 col-md-1" id="segunda">
                        <input type="number" min="1" max="9999" value="1" class="form-control qntd" onclick="mudaTotal(this)" onchange="mudaTotal(this)" id="qntd" name="qntd" maxlength="4">
                    </td>
                    <td class="col-sm-1 col-md-1 text-center" id="terceira"><strong id="preco">xxxx</strong></td>
                    <td class="col-sm-1 col-md-1 text-center soma" id="quarta"><strong id="total"></strong></td>
                    <td class="col-sm-1 col-md-1" id="quinta">
                        <button type="button" class="btn btn-danger" id="remove" onclick="removeLinha(this); somaTudo();">
                            <span class="glyphicon glyphicon-remove"></span> Remover
                        </button></td>
                </tr>
                <tr id="inner"></tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Subtotal</h5></td>
                    <td class="text-right"><h5><strong id="subtotal">R$ 0,00</strong></h5></td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h5>Desconto</h5><label for="descporc" id="porc">%
                            <input type="radio" id="descporc" name="desc" checked onclick="checaPorcent()">
                        </label>
                        <label for="descdin" id="din">$
                            <input type="radio" id="descdin" name="desc" onclick="checaDinheiro()">
                        </label></td>
                    <td class="text-right">
                        <input type="text" class="form-control tam" id="avista" onchange="simbolDinh(this)" onfocus="dinhFoco(this)">
                        <input type="text" class="form-control tam" id="percentual" onchange="simbolPorc()" onfocus="simbolFoco(this)">
                    </td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td><h4>Total</h4></td>
                    <td class="text-right">
                        <h4><strong id="tot-geral">R$ 0,00</strong></h4>
                    </td>
                </tr>
                <tr>
                    <td>   </td>
                    <td>   </td>
                    <td>   </td>
                    <td>
                        <button type="button" class="btn btn-danger" onclick="window.location.reload();" disabled id="cancel">
<!--                            <span class="glyphicon glyphicon-shopping-cart"></span>-->
                            <span class="	glyphicon glyphicon-remove"></span>
                            Cancela venda
                        </button></td>
                    <td>
                        <form method="POST" action="adicionaVenda.php">
                            <input type="hidden" id="val_tot_venda" value="R$0,00" name="total">
                            <input type="hidden" id="desc_din" value="R$0,00" name="descd">
                            <input type="hidden" id="desc_porc" value="0" name="descp">
                            <input type="hidden" id="tot_s_desc" value="R$0,00" name="subtotal">
                            <input type="hidden" id="itens" value="vazio" name="itens">
                            <input type="hidden" id="qntd_prod" value="0" name="qntd_prod">
                            <button type="submit" class="btn btn-success" id="confirmar" disabled>
                                Avançar <span class="glyphicon glyphicon-play"></span>
                            </button>
                        </form>
                        </td>
                </tr>
                </tbody>
            </table>
<!--        </div>-->
    </div>
</div>
<script type="text/javascript" src="../js/venda.js"></script>
</body>
</html>