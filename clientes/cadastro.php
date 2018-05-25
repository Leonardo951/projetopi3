<?php
require_once '../check.php';
require_once '../conexao.php';
require_once 'variaveis.php';
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

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../css/cadastro.css" rel="stylesheet">

        <script src="../js/ie-emulation-modes-warning.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    </head>
    <body>
        <div class="container">
            <img id="logo" src="../img/cables.png"/>
            <a href="../menuprincipal.php" class="btn btn-success-retorn">
                <span><i class="fa fa-arrow-circle-left"></i> Voltar ao menu</span>
            </a>
            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                <i class="glyphicon glyphicon-menu-hamburger"></i>
                <span>Ver clientes existentes</span>
            </a>
            <form class="form-horizontal" method="POST" action="insert.php">
                <br>
                <fieldset>
                    <div class="panel panel-primary"><br>
                        <!--                 Text input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="Nome">Nome</label>
                            <div class="col-md-8">
                                <input id="Nome" name="nome" placeholder="Nome Completo" value="<?php if(isset($nome)) { echo $nome;}else {echo '';} ?>" class="form-control input-md" required type="text">
                            </div>
                        </div>

                        <!-- Text input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="nome">CPF</label>
                            <div class="col-md-2">
                                <input id="cpf" name="cpf" placeholder="Apenas números" value="<?php if(isset($cpf)) { echo $cpf;}else {echo '';} ?>" class="form-control input-md" required="" type="text" maxlength="11" pattern="[0-9]+$">
                            </div>

                            <label class="col-md-1 control-label" for="Nome">Nascimento</label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                    <input id="dtnasc" name="dtnasc" value="<?php if(isset($dtnasc)) { echo $dtnasc;}else {echo '';} ?>"  placeholder="DD/MM/AAAA" class="form-control input-md" required type="text" maxlength="10" OnKeyPress="formatar('##/##/####', this)" onBlur="showhide()">
                                </div>
                            </div>

                            <!-- Multiple Radios (inline) -->

                            <label class="col-md-1 control-label" for="radios">Sexo</label>
                            <div class="col-md-4">
                                <label required class="radio-inline" for="sexoF" >
                                    <input name="sexo" id="sexoF" value="F" type="radio" <?php if(isset($sexo) && $sexo == "F") { echo'checked'; } else { echo ''; } ?> >
                                    Feminino
                                </label>
                                <label class="radio-inline" for="sexoM">
                                    <input name="sexo" id="sexoM" value="M" required type="radio" <?php if(isset($sexo) && $sexo == "M") { echo'checked'; }else { echo ''; } ?> >
                                    Masculino
                                </label>
                                <label class="radio-inline" for="sexoI">
                                    <input name="sexo" id="sexoI" value="I" type="radio" <?php if(isset($sexo) && $sexo == "I") { echo'checked'; } else { echo ''; } ?> >
                                    Outros
                                </label>
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="prependedtext">DDD</label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-earphone"></i></span>
                                    <select required class="form-control" name="ddd">
                                        <option></option>
                                        <?php
                                        $sql = 'SELECT ddd FROM tb_ddd;';
                                        $ddds = $conex->prepare($sql);
                                        $ddds->execute();
                                        while ($n = $ddds->fetch()) {
                                            $myddds[] = $n['ddd'];
                                        };
                                        for($i = 0; $i < count($myddds); ++$i) {
                                            if(isset($ddd) && $ddd == $myddds[$i]) {
                                                    echo '<option selected>'.$myddds[$i].'</option>';
                                                } else {
                                                    echo '<option>'.$myddds[$i].'</option>';
                                                }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <label class="col-md-1 control-label" for="prependedtext">Telefone</label>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="	glyphicon glyphicon-phone-alt"></i></span>
                                    <input id="prependedtext" name="tel" value="<?php if(isset($tel)) { echo $tel;}else {echo '';} ?>" class="form-control" placeholder="XXXX-XXXX" type="tel" maxlength="8"  pattern="\[0-9]{2}\ [0-9]{4,6}-[0-9]{3,4}$">
                                </div>
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="prependedtext">Email</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                    <input id="prependedtext" name="email" value="<?php if(isset($mail)) { echo $mail;}else {echo '';} ?>" class="form-control" placeholder="email@email.com" required type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" >
                                </div>
                            </div>
                        </div>
                        <!-- Search input-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="CEP">CEP</label>
                            <div class="col-md-2">
                                <input id="cep" name="cep" placeholder="Apenas números" value="<?php if(isset($cep)) { echo $cep;}else {echo '';} ?>" class="form-control input-md" required type="search" maxlength="8" pattern="[0-9]+$">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn-primary">Pesquisar</button>
                            </div>
                        </div>

                        <!-- Prepended text-->
                        <div class="form-group">
                            <label class="col-md-2 control-label" for="prependedtext">Endereço</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon"><?php if(isset($tipo)) { echo $tipo.':';}else {echo 'Logradouro:';} ?></span>
                                    <input id="quadra" name="logradouro" value="<?php if(isset($logradouro)) { echo $logradouro;}else {echo '';} ?>" class="form-control" required readonly type="text">
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Complemento</span>
                                    <input id="comple" name="compl" class="form-control" type="text">
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
                            <label class="col-md-2 control-label" for="prependedtext"></label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-addon">Cidade</span>
                                    <input id="cidade" name="cidade" value="<?php if(isset($cidade)) { echo $cidade;}else {echo '';} ?>" class="form-control" required readonly type="text">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Bairro</span>
                                    <input id="bairro" name="bairro" value="<?php if(isset($bairro)) { echo $bairro;}else {echo '';} ?>" class="form-control" required readonly type="text">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <span class="input-group-addon">Estado</span>
                                    <input id="estado" name="estado" value="<?php if(isset($uf)) { echo $uf;}else {echo '';} ?>" class="form-control" required readonly type="text">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="Cadastrar"></label>
                                <div class="col-md-8">
                                    <button id="Cadastrar" name="Cadastrar" class="btn btn-success" type="Submit">Cadastrar</button>
                                    <button id="Cancelar" name="limpar" class="btn btn-danger" type="Reset">Limpar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>