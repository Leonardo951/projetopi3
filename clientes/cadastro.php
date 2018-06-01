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
            <a href="../menuprincipal.php" class="btn btn-success-retorn">
                <span><i class="fa fa-arrow-circle-left"></i> Voltar ao menu</span>
            </a>
            <a href="clientes.php" class="btn btn-primary">
                <i class="glyphicon glyphicon-menu-hamburger"></i>
                <span>Ver clientes existentes</span>
            </a>
            <?php if($_SESSION['recado'] == 'adicionado') {?>
            <div class="alert alert-success">
                <strong>Adicionado! </strong>Novo cliente adicionado com sucesso!
                <button class="close" data-dismiss="alert">x</button>
            </div>
            <?php } elseif($_SESSION['recado'] == 'erroadicao') {?>
            <div class="alert alert-warning">
                <strong>Algo deu errado. </strong>Ocorreu um erro ao adicionar este cliente!
                <button class="close" data-dismiss="alert" id="message">x</button>
            </div>
            <?php } $_SESSION['recado'] = 'vazio';?>
            <form class="form-horizontal" method="POST" action="insert.php">
                <fieldset>
                    <div class="panel panel-primary"><br>
                        <div class="pessoa text-center">
                            <label class="radio-inline" for="pf" >
                                <input name="pessoa" id="pf" value="PF" type="radio" onclick="tipoPessoaFis()" checked>
                                Pessoa Física
                            </label>
                            <label class="radio-inline" for="pj">
                                <input name="pessoa" id="pj" value="PJ" required type="radio" onclick="tipoPessoaJur()">
                                Pessoa Jurídica
                            </label>
                        </div>
                        <!--                        Se for PF mostrar essa div-->
                        <div id="fisica">
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="nome">Nome</label>
                            <div class="col-md-8">
                                <input id="nome" name="nome" placeholder="Nome Completo" class="form-control input-md" required type="text">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="cpf">CPF</label>
                            <div class="col-md-2">
                                <input id="cpf" name="cpf" placeholder="Apenas números" class="form-control input-md" required type="text" maxlength="14">
                            </div>

                            <label class="col-md-1 control-label" for="dtnasc">Nascimento</label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input id="dtnasc" name="dtnasc" placeholder="DD/MM/AAAA" class="form-control input-md" required type="text" maxlength="10">
                                </div>
                            </div>

                            <!-- Multiple Radios (inline) -->

                            <label class="col-md-1 control-label">Sexo</label>
                            <div class="col-md-4">
                                <label class="radio-inline" for="sexoF" >
                                    <input name="sexo" id="sexoF" value="F" type="radio" >
                                    Feminino
                                </label>
                                <label class="radio-inline" for="sexoM">
                                    <input name="sexo" id="sexoM" value="M" required type="radio" >
                                    Masculino
                                </label>
                                <label class="radio-inline" for="sexoI">
                                    <input name="sexo" id="sexoI" value="I" type="radio" >
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
                                    <select required class="form-control" name="ddd" id="ddd">
                                        <option></option>
                                        <?php
                                        $sql = 'SELECT ddd FROM tb_ddd;';
                                        $ddds = $conex->prepare($sql);
                                        $ddds->execute();
                                        while ($n = $ddds->fetch()) {
                                            $myddds[] = $n['ddd'];
                                        };
                                        for($i = 0; $i < count($myddds); ++$i) {
                                            echo '<option>'.$myddds[$i].'</option>';
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <label class="col-md-1 control-label" for="tel">Telefone</label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                    <input id="tel" name="tel" class="form-control" placeholder="XXXX-XXXX" type="tel" maxlength="9">
                                </div>
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="email">Email</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="email" name="email" class="form-control" placeholder="email@email.com" required type="email" >
                                </div>
                            </div>
                        </div>
                        </div>
<!--                        Se for PJ mostrar essa div-->
                        <div id="juridica">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="nome">Nome da empresa</label>
                                <div class="col-md-8">
                                    <input id="empresa" name="empresa" placeholder="Empresa" class="form-control input-md" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="raao_soc">Razão Social</label>
                                <div class="col-md-8">
                                    <input id="razao_soc" name="razao_soc" placeholder="Razão Social" class="form-control input-md" type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="resp">Responsável</label>
                                <div class="col-md-8">
                                    <input id=resp name="resp" placeholder="Responsável" class="form-control input-md" type="text">
                                </div>
                            </div>

                            <!-- Text input-->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="cnpj">CNPJ</label>
                                <div class="col-md-3">
                                    <input id="cnpj" name="cnpj" placeholder="Apenas números" class="form-control input-md" type="text" maxlength="18">
                                </div>
<!--                                <div class="form-group">-->
                                    <label class="col-md-1 control-label" for="email">Email</label>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                            <input id="mail" name="mail" class="form-control" placeholder="email@email.com" type="email">
                                        </div>
<!--                                    </div>-->
                                </div>
                            </div>

                            <!-- Prepended text-->
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="ddd">DDD</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                        <select class="form-control" name="ddd_pj" id="ddd_pj">
                                            <option></option>
                                            <?php
                                            $sql = 'SELECT ddd FROM tb_ddd;';
                                            $ddds = $conex->prepare($sql);
                                            $ddds->execute();
                                            while ($n = $ddds->fetch()) {
                                                $myddds[] = $n['ddd'];
                                            };
                                            for($i = 0; $i < count($myddds); ++$i) {
                                                echo '<option>'.$myddds[$i].'</option>';
                                            } ?>
                                        </select>
                                    </div>
                                </div>
                                <label class="col-md-1 control-label" for="tel_pj">Telefone</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-phone-alt"></i></span>
                                        <input id="tel_pj" name="tel_pj" class="form-control" placeholder="XXXX-XXXX" type="tel" maxlength="9">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Search input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="cep">CEP</label>
                            <div class="col-md-2">
                                <input id="cep" name="cep" placeholder="Apenas números" class="form-control input-md" type="search" maxlength="10">
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="pesquisar" class="btn-primary" onclick="getEndereco()">Pesquisar</button>
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="logradouro">Endereço</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Logradouro</span>
                                    <input id="logradouro" name="logradouro" class="form-control" required readonly type="text">
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Complemento</span>
                                    <input id="compl" name="compl" class="form-control" type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">Nº</span>
                                    <input id="numero" name="numero" class="form-control" type="text">
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="cidade"></label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Cidade</span>
                                    <input id="cidade" name="cidade" class="form-control" required readonly type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Bairro</span>
                                    <input id="bairro" name="bairro" class="form-control" required readonly type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">Estado</span>
                                    <input id="estado" name="estado" class="form-control" required readonly type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="Cadastrar"></label>
                                <div class="col-md-8">
                                    <button id="Cadastrar" name="Cadastrar" class="btn btn-success" type="Submit">Cadastrar</button>
                                    <button id="Cancelar" name="limpar" class="btn btn-danger" type="Reset" onclick="limparPJ()">Limpar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <script type="text/javascript" src="../js/buscarCep.js"></script>
        <script type="text/javascript" src="../js/cadastro.js"></script>
    </body>
</html>