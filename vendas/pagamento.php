<?php
require_once '../functions/check.php';
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
    <!-- Custom styles for this template -->
    <link href="../css/pagamento.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <script src="../js/ie-emulation-modes-warning.js" type="text/javascript"></script>
    <script src="../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="type/javascript"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/jquery.ui.css" />
    <script src="../js/jquery.ui.js" type="text/javascript"></script>

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" id="bootstrap-css">
</head>
<body>
<div class="container">
    <div class="row">
        <a href="../menuprincipal.php">
            <img src="../img/cables.png/" class="img-logo-usuario"/>
        </a>
        <form class="form-horizontal">
            <fieldset id="pag">
                <br>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="buscaCliente">Cliente</label>
                    <div class="col-md-5">
                        <input type="text" id="buscaCliente" placeholder="Nome ou CPF" class="form-control tam" autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="usuario">Vendedor</label>
                    <div class="col-md-5">
                        <input type="text" id="usuario" readonly class="form-control tam" required value="<?php echo base64_decode($_SESSION['usuario']);?>">
                    </div>
                </div>
                <?php
                $pk = base64_decode($_GET['venda']);
                $sql = 'SELECT vl_total, vl_desc, subtotal FROM tb_venda WHERE pk_venda = :pk_venda';
                $stmt = $conex->prepare($sql);
                $stmt->bindParam(':pk_venda', $pk);
                $stmt->execute();
                $dados = $stmt->fetch();
                ?>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="subtotal">Subtotal</label>
                    <div class="col-md-2">
                        <input type="text" id="subtotal" readonly required class="form-control tam" value="<?php  echo $dados['subtotal']; ?>">
                    </div>
                    <label class="col-md-4 control-label" for="desconto">Desconto</label>
                    <div class="col-md-2">
                        <input type="text" id="desconto" readonly required class="form-control tam" value="<?php echo $dados['vl_desc']; ?>">
                    </div>
                    <label class="col-md-4 control-label" for="total">Total</label>
                    <div class="col-md-2">
                        <input type="text" id="total" readonly required class="form-control tam" value="<?php echo $dados['vl_total']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4 control-label" for="selectbasic">Produtos da compra</label>
                    <div>
                        <table class="table table-hover" id="prods">
                            <thead>
                            <tr>
                                <th>Produtos</th>
                                <th>Marca</th>
                                <th>Categoria</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $itens = json_decode($_SESSION['itens']);
                            $quants = json_decode($_SESSION['quantidades']);
//                            unset($_SESSION['itens']);
//                            unset($_SESSION['quantidades']);
                            $qnt = count($itens);
                            for($i = 0; $i < $qnt; $i++) {
                                $query = 'SELECT * FROM view_produtos WHERE cod_prod = :cod;';
                                $stmt = $conex->prepare($query);
                                $stmt->bindParam('cod', $itens[$i]);
                                $stmt->execute();
                                $info = $stmt->fetch();
                                echo '
                                <tr>
                                   
                                    <td>'. $info["nome_prod"] .'</td>
                                    <td>'. $info["marca"] .'</td>
                                    <td>'. $info["categoria"] .'</td>
                                    <td class="text-center">'. $quants[$i] .'</td>
                                    <td class="text-center">'. $info["preco"] .'</td>
                                    <td class="text-center">'. $info["preco"]*$quants[$i] .'</td>
                                </tr>';
                            };
                            ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 col-md-10 col-md-offset-1">
                        <div class='header'>
                            Forma de pagamento
                        </div>
                        <div class="main">
                            <div class='payments'>
                                <div class='button' id="avista" onclick="formaPag()">
                                    A vista
                                    <br><br>
                                    <i class="fa fa-money"></i>
                                </div>
                                <div class='button' id="debito" onclick="desabilitaPag()">
                                    Débito
                                    <br><br>
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <div class='button' id="credito" onclick="desabilitaPag()">
                                    Crédito
                                    <br><br>
                                    <i class="fa fa-cc-visa"></i>
                                    <br>
                                    <i class="fa fa-cc-mastercard"></i>
                                </div>
                                <div class="form-group lateral">
                                    <label class="col-md-4 control-label vista" for="pagar">Valor a pagar</label>
                                    <div class="col-md-3">
                                        <input type="text" id="pagar" class="form-control tam vista" disabled>
                                    </div>
                                    <label class="col-md-4 control-label vista" for="pago">Valor entregue</label>
                                    <div class="col-md-3">
                                        <input type="text" id="pago" class="form-control tam vista" onchange="trocoDinn()">
                                    </div>
                                    <label class="col-md-4 control-label vista" for="troco">Troco</label>
                                    <div class="col-md-3">
                                        <input type="text" id="troco" class="form-control tam vista" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class='footer'></div>
                        <div class="form-group">
                            <label class="col-md-4 control-label" for="register"></label>
                            <div class="col-md-8">
                                <button id="register" class="btn btn-success" type="button" disabled>Registrar</button>
                                <br><br>
                                <a href="venda.php"><button id="cancel" class="btn btn-danger" type="button">Cancelar compra</button></a>
                            </div>
                        </div>
            </fieldset>
        </form>
    </div>
</div>
<script src="../js/pagamento.js" type="text/javascript"></script>
</body>
</html>