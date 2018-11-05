<?php
require_once '../functions/check.php';
include_once '../conexao.php';
?>
<!DOCTYPE html>

<html lang="pt-br" xmlns="http://www.w3.org/1999/html">
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
    <link href="../css/prod_vendidos.css" rel="stylesheet">

    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <script src="../js/ie-emulation-modes-warning.js" type="text/javascript"></script>
    <script src="../js/jquery-3.3.1.min.js" type="text/javascript"></script>
    <script src="../js/jquery.mask.min.js" type="text/javascript"></script>
    <script src="../js/bootstrap.min.js" type="type/javascript"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/jquery.ui.css" />
    <script src="../js/jquery.ui.js" type="text/javascript"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <a href="../index.php">
            <img src="../img/cables.png" class="img-logo-usuario"/>
        </a>
        <?php
        if(isset($_GET['produto'])){
            $prod = $_GET['produto'];
            $sql = 'SELECT nome_prod, cod_prod FROM tb_produto WHERE cod_prod = :cod_prod;';
            $prepara = $conex->prepare($sql);
            $prepara->bindParam('cod_prod', $prod);
            $prepara->execute();
            $row = $prepara->fetch();
            $cod_prod = $row['cod_prod'];
            $nome_prod = $row['nome_prod'];
            echo '<div class="form">
                    <label for="nome_prod" class="col-md-2 control-label">Produto:</label>
                    <input type="text" value="' . $nome_prod . '" name="nome_prod" id="nome_prod" class=" form-control">
                    <br>
                    <label for="codigo" class="col-md-2 control-label">Código de produto:</label>
                    <input type="text" value="' . $cod_prod . '" name="codigo" id="codigo" class="form-control">
                </div>
                <br><br>
        <table id="mytab" class="table table-striped table-hover">
            <thead>
                <th id="liforn">Fornecedores</th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
            </thead>
            <thead>
                <th>Nome</th>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>E-mail</th>
                <th>DDD</th>
                <th>Telefone</th>
            </thead>
            <tbody>';
            $sql = 'SELECT * FROM view_prod_vend WHERE cod_prod = :cod_prod;';
                $prepara = $conex->prepare($sql);
                $prepara->bindParam('cod_prod', $prod);
                $prepara->execute();
                while ( $row = $prepara->fetch() ) {
                    $nome = $row['nome'];
                    $rz = $row['razao_soc'];
                    $cnpj = $row['cnpj'];
                    $email = $row['email'];
                    $ddd = $row['fk_ddd'];
                    $tel = $row['telefone'];
                    echo '<tr>
                        <td>' . $nome . '</td>
                        <td>' . $rz . '</td>
                        <td>' . $cnpj . '</td>
                        <td>' . $email . '</td>
                        <td>' . $ddd . '</td>
                        <td>' . $tel . '</td>
                    </tr>';
                }
            if( !$prepara->rowCount() > 0){
                    echo '
                    <thead>
                        <th</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <thead>
                        <th</th>
                        <th></th>
                        <th></th>
                        <th>Ops! Nenhum fornecedor cadastrado fornece este produto</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>';
                }
        }elseif (isset($_GET['fornecedor'])){
            $cnpj = $_GET['fornecedor'];
            $sql = 'SELECT * FROM view_prod_vend WHERE cnpj = :cnpj;';
            $prepara = $conex->prepare($sql);
            $prepara->bindParam('cnpj', $cnpj);
            $prepara->execute();
            $row = $prepara->fetch();
            $nome = $row['nome'];
            $cnpj= $row['cnpj'];
            echo '<div class="form">
                    <label for="nome" class="col-md-2 control-label">Fornecedor:</label>
                    <input type="text" value="' . $nome . '" name="nome" id="nome" class=" form-control">
                    <br>
                    <label for="cnpj" class="col-md-2 control-label">CNPJ:</label>
                    <input type="text" value="' . $cnpj . '" name="cnpj" id="cnpj" class="form-control">
                </div>
                <br><br>
        <table id="mytab" class="table table-striped table-hover">
            <thead>
                <th id="liforn">Produtos</th>
                <th></th>
                <th></th>
                <th></th>
            </thead>
            <thead>
                <th>Código</th>
                <th>Produto</th>
                <th>Categoria</th>
                <th>Marca</th>
            </thead>
            <tbody>';
            $sql = 'SELECT * FROM view_prod_vend WHERE cnpj = :cnpj;';
            $prepara = $conex->prepare($sql);
            $prepara->bindParam('cnpj', $cnpj);
            $prepara->execute();
            while ( $row = $prepara->fetch() ) {
                $produto = $row['nome_prod'];
                $cod = $row['cod_prod'];
                $marca = $row['marca'];
                $fk_categoria = $row['fk_categoria'];
                $sql = 'SELECT categoria FROM tb_categoria WHERE pk_categoria = :pk_categoria;';
                $prepara = $conex->prepare($sql);
                $prepara->bindParam('pk_categoria', $fk_categoria);
                $prepara->execute();
                $cat = $prepara->fetch();
                $categoria = $cat['categoria'];
                echo '<tr>
                        <td>' . $cod . '</td>
                        <td>' . $produto . '</td>
                        <td>' . $categoria . '</td>
                        <td>' . $marca . '</td>
                    </tr>';
            }
        }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>