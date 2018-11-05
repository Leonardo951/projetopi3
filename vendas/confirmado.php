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
    <link href="../css/confirmar.css" rel="stylesheet">

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
    <div class="row text-center">
        <a href="../index.php">
            <img src="../img/cables.png" class="img-logo-usuario"/>
        </a>
        <fieldset id="pag" class="text-center">
            <?php
            $result = [];
            if(isset($_SESSION['venda'])){
                $itens = json_decode($_SESSION['itens']);
                $quants = json_decode($_SESSION['quantidades']);
                $id_venda = base64_decode($_SESSION['venda']);
                unset($_SESSION['itens']);
                unset($_SESSION['quantidades']);
                unset($_SESSION['venda']);
                $qnt = count($itens);
                $query = 'SELECT cod_venda FROM tb_venda WHERE pk_venda = :pk';
                $stmt = $conex->prepare($query);
                $stmt->bindParam('pk', $id_venda);
                $stmt->execute();
                $array = $stmt->fetch();
                $codigo = $array['cod_venda'];
                for($i = 0; $i < $qnt; $i++) {
                    $query = 'SELECT pk_prod FROM tb_produto WHERE cod_prod = :cod;';
                    $stmt = $conex->prepare($query);
                    $stmt->bindParam('cod', $itens[$i]);
                    $stmt->execute();
                    $info = $stmt->fetch();
                    $q = $i+1;
                    $query = 'INSERT INTO tb_prod_vendidos (fk_venda, fk_prod, quantd) VALUES (?,?,?);';
                    $stmt = $conex->prepare($query);
                    $stmt->bindValue(1, $id_venda);
                    $stmt->bindValue(2, $info['pk_prod']);
                    $stmt->bindValue(3, $quants[$q]);
                    if($stmt->execute()){
                        array_push($result, 'true');
                    }else{
                        array_push($result, 'false');
                    }
                }
            }else{
                array_push($result, 'false');
            }
            if(in_array('false', $result)){
                echo '
                    <div class="text">
                        <h3>Erro ao registrar</h3>
                        <a href="venda.php">
                            <button id="register" class="btn btn-success" type="button">
                                Reiniciar venda
                            </button>
                        </a>
                        <a href="../index.php">
                            <button id="menu" class="btn btn-info" type="button">
                                Voltar para o menu
                            </button>
                        </a>
                    </div>';
            }else{
                echo '
                    <div class="text">
                        <h3>A sua venda foi confirmada!</h3>
                        <h4>N°:   '. $codigo . '</h4>
                        <a href="venda.php">
                            <button id="register" class="btn btn-success" type="button">
                                Registrar nova venda
                            </button>
                        </a>
                        <a href="../index.php">
                            <button id="menu" class="btn btn-info" type="button">
                                Voltar para o menu
                            </button>
                        </a>
                    </div>';
            }
            ?>
        </fieldset>
    </div>
</div>
<script src="../js/pagamento.js" type="text/javascript"></script>
</body>
</html>