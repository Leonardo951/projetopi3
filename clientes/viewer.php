<?php
require_once '../check.php';
require_once '../conexao.php';
?>
<!DOCTYPE html>
<html>
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
    <link href="../css/cadastro.css" rel="stylesheet">
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
</head>
<body>
<div class="container">
    <img id="logo" src="../img/cables.png"/>
    <a href="clientes.php" class="btn btn-success-retorn">
        <span><i class="fa fa-arrow-circle-left"></i> Retornar</span>
    </a>
    <form class="form-horizontal" method="POST" action="update.php">
        <fieldset>
            <div class="panel panel-primary"><br>
                <?php
                    $id = base64_decode($_GET['view']);
                    $sql = 'SELECT * FROM view_clientes_pf WHERE pk_clie_pf = :pk_clie_pf;';
                    $prepara = $conex->prepare($sql);
                    $prepara->bindParam(':pk_clie_pf', $id);
                    $prepara->execute();
                    $dados = $prepara->fetch();
                    $dt = implode("/",array_reverse(explode("-",$dados['dt_nasc'])));
                echo '
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="nome">Nome</label>
                        <div class="col-md-8">
                            <input id="nome" name="nome" disabled value="'.$dados["nome"].'" onchange="desabilitaEdit()" placeholder="Nome Completo" class="form-control input-md" required type="text">
                        </div>
                    </div>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="cpf">CPF</label>
                        <div class="col-md-2">
                            <input id="cpf" name="cpf" disabled placeholder="Apenas números" onchange="desabilitaEdit()" value="'.$dados["cpf"].'" class="form-control input-md" required type="text" maxlength="14">
                        </div>

                        <label class="col-md-1 control-label" for="dtnasc">Nascimento</label>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input id="dtnasc" name="dtnasc" disabled value="'.$dt.'" onchange="desabilitaEdit()" placeholder="DD/MM/AAAA" class="form-control input-md" required type="text" maxlength="10">
                            </div>
                        </div>';
                        $check_f = '';
                        $check_m = '';
                        $check_i = '';
                        if ($dados {'sexo'} == 'M') {
                            $check_m = 'checked';
                        } elseif($dados {'sexo'} == 'F') {
                            $check_f = 'checked';
                        } else {
                            $check_i = 'checked';
                        }
                        echo '
                        <label class="col-md-1 control-label">Sexo</label>
                        <div class="col-md-4">
                            <label class="radio-inline" for="sexoF" >
                                <input disabled name="sexo" '. $check_f .'id="sexoF" onchange="desabilitaEdit()"  value="F" type="radio" >
                                Feminino
                            </label>
                            <label class="radio-inline" for="sexoM">
                                <input disabled name="sexo" id="sexoM" value="M" onchange="desabilitaEdit()" required type="radio" '. $check_m .'>
                                Masculino
                            </label>
                            <label class="radio-inline" for="sexoI">
                                <input disabled name="sexo" id="sexoI" value="I" onchange="desabilitaEdit()" type="radio" '. $check_i .'>
                                Outros
                            </label>
                        </div>
                    </div>
                    <!-- Prepended text-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="ddd">DDD</label>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                <select required class="form-control" name="ddd" id="ddd" disabled onchange="desabilitaEdit()" >';
                                    $sql = 'SELECT ddd FROM tb_ddd;';
                                    $ddds = $conex->prepare($sql);
                                    $ddds->execute();
                                    while ($n = $ddds->fetch()) {
                                        $myddds[] = $n['ddd'];
                                    };
                                    for($i = 0; $i < count($myddds); ++$i) {
                                        if($myddds[$i] != $dados['ddd']) {
                                            echo '<option>'.$myddds[$i].'</option>';
                                        } else {
                                            echo '<option selected>'.$myddds[$i].'</option>';
                                        }
                                    }
                                    echo '
                                </select>
                            </div>
                        </div>
                        <label class="col-md-1 control-label" for="tel">Telefone</label>
                        <div class="col-md-2">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                <input id="tel" name="tel" value="'.$dados["telefone"].'" onchange="desabilitaEdit()" class="form-control" disabled placeholder="XXXX-XXXX" type="tel" maxlength="9">
                            </div>
                        </div>
                    </div>

                    <!-- Prepended text-->
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="email">Email</label>
                        <div class="col-md-5">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input id="email" name="email" value="'.$dados["email"].'" onchange="desabilitaEdit()" class="form-control" disabled placeholder="email@email.com" required type="email" >
                            </div>
                        </div>
                    </div>
                <!-- Search input-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cep">CEP</label>
                    <div class="col-md-2">
                        <input id="cep" name="cep" placeholder="Apenas números" onchange="desabilitaEdit()" value="'.$dados["cep"].'" disabled class="form-control input-md" type="search" maxlength="10">
                    </div>
                    <div class="col-md-2">
                            <button type="button" id="pesquisar" class="btn-primary" disabled onclick="getEndereco()">Pesquisar</button>
                    </div>
                </div>

                <!-- Prepended text-->
                <div class="form-group">
                    <label class="col-md-2 control-label" for="logradouro">Endereço</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">Logradouro</span>
                            <input id="logradouro" name="logradouro" onchange="desabilitaEdit()" class="form-control" value="'.$dados["logradouro"].'" required disabled type="text">
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Complemento</span>
                            <input id="compl" name="compl" disabled onchange="desabilitaEdit()" class="form-control" value="'.$dados["complemento"].'" type="text">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Nº</span>
                            <input id="numero" name="numero" onchange="desabilitaEdit()" disabled class="form-control" type="text" value="'.$dados["numero"].'">
                        </div>

                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cidade"></label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-addon">Cidade</span>
                            <input id="cidade" name="cidade" class="form-control" value="'.$dados["cidade"].'" required disabled type="text">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">Bairro</span>
                            <input id="bairro" name="bairro" class="form-control" value="'.$dados["bairro"].'" required disabled type="text">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group">
                            <span class="input-group-addon">Estado</span>
                            <input id="estado" name="estado" class="form-control" value="'.$dados["uf"].'" required disabled type="text">
                        </div>
                    </div> '?>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="Cadastrar"></label>
                        <div class="col-md-8">
                            <button id="atualizar" class="btn btn-success" disabled type="Submit">Atualizar</button>
                            <button id="editar" class="btn btn-primary" type="button" onclick="editarCampos()">Editar campos</button>
                        </div>
                    </div>
                </div>
        </fieldset>
    </form>
</div>
<script type="text/javascript" src="../js/buscarCep.js"></script>
<script type="text/javascript" src="../js/view.js"></script>
</body>
</html>