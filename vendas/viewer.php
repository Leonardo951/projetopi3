<?php
require_once '../functions/check.php';
require_once '../conexao.php';
date_default_timezone_set('America/Sao_Paulo');
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
        <img src="../img/cables.png" class="img-logo-usuario"/>
        <a href="relVendas.php" class="btn btn-success-retorn btn_ini">
            <span><i class="fa fa-arrow-circle-left"></i> Retornar</span>
        </a>
        <div class="col-md-6">
            <?php
            if ($_SESSION['recado'] == 'erroexclui') {?>
                <div class="alert alert-success">
                    <strong>Ops! </strong>Ocorreu um erro!
                    <button class="close" data-dismiss="alert">x</button>
                </div>
            <?php }
            $_SESSION['recado'] = 'vazio';
            ?>
        </div>
        <form class="form-horizontal">
            <fieldset id="pag">
                <br>
                <?php
                $cod_venda = $_GET['venda'];
                $query = 'SELECT * FROM tb_venda WHERE cod_venda = :cod;';
                $stmt = $conex->prepare($query);
                $stmt->bindParam('cod', $cod_venda);
                $stmt->execute();
                $into = $stmt->fetch();
                $num_venda = $into["pk_venda"];
                $vl_tot = $into["vl_total"];
                $vl_sub = $into["subtotal"];
                $desc = $into["vl_desc"];
                $dt_hr = $into["dt_hr_venda"];
                $dt_agora = new DateTime();
                $dt_venda = new DateTime($dt_hr);
                $res = $dt_agora->diff($dt_venda);
                $res->format('%d');
                $tempo = intval($res);
                if($into['fk_clie_pj'] == null){
                    $query = 'SELECT * FROM view_vendas_pf WHERE cod_venda = :cod;';
                    $stmt = $conex->prepare($query);
                    $stmt->bindParam('cod', $cod_venda);
                    $stmt->execute();
                    $into = $stmt->fetch();
                    echo '
                    <div class="form-group" id="pesFis">
                    <label class="col-md-4 control-label" for="buscaCliente">Cliente</label>
                    <div class="col-md-5">
                        <input type="text" id="buscaCliente" class="form-control tam" readonly value="'. $into["nome"] .'">
                    </div>
                </div>    ';
                }else{
                    $query = 'SELECT * FROM view_vendas_pj WHERE cod_venda = :cod;';
                    $stmt = $conex->prepare($query);
                    $stmt->bindParam('cod', $cod_venda);
                    $stmt->execute();
                    $into = $stmt->fetch();
                    echo '
                    <div class="form-group" id="pesJur">
                    <label class="col-md-4 control-label" for="buscaPj">Cliente</label>
                    <div class="col-md-4">
                        <input type="text" id="buscaPj" value="'. $into["empresa"] .'" class="form-control tam">
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="buscaResp">Responsável</label>
                        <div class="col-md-4">
                            <input type="text" id="buscaResp" value="'. $into["responsavel"] .'" class="form-control tam">
                        </div>
                        <p class="text-warning" id="alertPJ"><i class="material-icons">&#xe002;</i></p>
                    </div>
                </div> ';
                }
                echo '
                    <div class="form-group">
                    <label class="col-md-4 control-label" for="usuario">Vendedor</label>
                    <div class="col-md-5">
                        <input type="text" id="usuario" readonly class="form-control tam" required value="'. $into["nome_usuario"] .'">
                    </div>
                </div> 
                <div class="form-group">
                    <label class="col-md-4 control-label" for="subtotal">Subtotal</label>
                    <div class="col-md-2">
                        <input type="text" id="subtotal" readonly required class="form-control tam" value="'. $vl_sub .'">
                    </div>
                    <label class="col-md-4 control-label" for="desconto">Desconto</label>
                    <div class="col-md-2">
                        <input type="text" id="desconto" readonly required class="form-control tam" value="'. $desc .'">
                    </div>
                    <label class="col-md-4 control-label" for="total">Total</label>
                    <div class="col-md-2">
                        <input type="text" id="total" readonly required class="form-control tam" value="'. $vl_tot .'">
                    </div>
                </div> ';
                echo '
                <div class="form-group">
                    <label class="col-md-4 control-label" for="selectbasic">Produtos da compra</label>
                    <div>
                        <div id="prod">
                            <table class="table table-hover">
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
                                <tbody>';
                $query = 'SELECT fk_prod, quantd FROM tb_prod_vendidos WHERE fk_venda = :fk_venda;';
                $stmt = $conex->prepare($query);
                $stmt->bindParam('fk_venda', $num_venda);
                $stmt->execute();
                $i = 0;
                while ($resultado = $stmt->fetch()){
                    $fk_prod[] = $resultado['fk_prod'];
                    $quant[] = $resultado['quantd'];
                    $query = 'SELECT * FROM view_produtos WHERE pk_prod = :pk_prod;';
                    $stmt = $conex->prepare($query);
                    $stmt->bindParam('pk_prod', $fk_prod[$i]);
                    $stmt->execute();
                    $info = $stmt->fetch();
                    echo '
                                                    <tr>
                                                       
                                                        <td>'. $info["nome_prod"] .'</td>
                                                        <td>'. $info["marca"] .'</td>
                                                        <td>'. $info["categoria"] .'</td>
                                                        <td class="text-center">'. $quant[$i] .'</td>
                                                        <td class="text-center">'. $info["preco"] .'</td>
                                                        <td class="text-center">'. $info["preco"]*$quant[$i] .'</td>
                                                    </tr>';
                    $i++;
                };
                echo'
                                </tbody>
                            </table>
                        </div>
                    </div>
                <!-- DeleteVenda HTML -->
                <div id="excluirVenda" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="delete.php" method="POST">
                                <div class="modal-header">
                                    <h4 class="modal-title">Excluir venda</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <b><p>Deseja realmente excluir o registro desta venda?</p></b>
                                    <p class="text-warning"><small>Essa ação não poderá ser desfeita...</small></p>
                                    <input name="venda" type="hidden" value="' . $cod_venda . '" />
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                    <input type="submit" class="btn btn-danger" value="Excluir">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>';
                if($tempo <= 7){
                    echo '
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="edit"></label>
                        <div class="col-md-9 text-right">
                            <a href="#excluirVenda" data-toggle="modal">
                                <button id="exclui" class="btn btn-danger" type="button">
                                    Excluir
                                </button>
                            </a>
                        </div>
                    </div>';
                }
                ?>
            </fieldset>
        </form>
    </div>
</div>
</body>
</html>