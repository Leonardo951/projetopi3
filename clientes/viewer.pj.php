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
    <link href="../css/view.css" rel="stylesheet">
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
    <a href="clientes.php" class="btn btn-success-retorn btn_ini">
        <span><i class="fa fa-arrow-circle-left"></i> Retornar</span>
    </a>
    <?php
    if($_SESSION['recado'] == 'erroend') {?>
        <div class="alert alert-warning">
            <strong>Ops! </strong>Houve um problema ao atualizar o endereço.
            <button class="close" data-dismiss="alert">x</button>
        </div>
    <?php } elseif($_SESSION['recado'] == 'editado') {?>
        <div class="alert alert-success">
            <strong>Modificado! </strong>As informações foram alteradas com sucesso!
            <button class="close" data-dismiss="alert">x</button>
        </div>
    <?php } elseif($_SESSION['recado'] == 'erroedicao') {?>
        <div class="alert alert-danger">
            <strong>Algo deu errado. </strong>Ocorreu um erro ao modificar os dados deste cliente!
            <button class="close" data-dismiss="alert">x</button>
        </div>
    <?php }
    $_SESSION['recado'] = 'vazio';
    ?>
    <form class="form-horizontal" method="POST" action="update.pj.php">
        <fieldset>
            <div class="panel panel-primary"><br>
                <?php
                $id = base64_decode($_GET['view']);
                $sql = 'SELECT * FROM view_clientes_pj WHERE pk_cliente_pj = :pk_cliente_pj;';
                $prepara = $conex->prepare($sql);
                $prepara->bindParam(':pk_cliente_pj', $id);
                $prepara->execute();
                $dados = $prepara->fetch();
                echo '<!-- Modal para confirmar a exclusão -->
                        <div id="confirmDelete" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="delete.pj.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Excluir Cliente</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <b><p>Deseja realmente excluir este cliente?</p></b>
                                            <p class="text-warning"><small>Essa ação não poderá ser desfeita...</small></p>
                                            <input name="id" type="hidden" value="' . $id . '" />
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                            <input type="submit" class="btn btn-danger" value="Excluir">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>';
                // continuando a apresentar os dados
                echo '
                    <div class="form-group">
                        <input name="id" type="hidden" value="' . $id . '" />
                        <label class="col-md-2 control-label" for="empresa">Empresa</label>
                        <div class="col-md-8">
                            <input id="empresa" name="empresa" disabled value="'.$dados["empresa"].'" onchange="desabilitaEdit()" placeholder="Nome fantasia" class="form-control input-md" required type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="razao_soc">Razão Social</label>
                        <div class="col-md-8">
                            <input id="razao_soc" name="razao_soc" disabled value="'.$dados["razao_soc"].'" onchange="desabilitaEdit()" placeholder="Razão Social" class="form-control input-md" required type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="resp">Responsável</label>
                        <div class="col-md-8">
                            <input id="resp" name="resp" disabled value="'.$dados["responsavel"].'" onchange="desabilitaEdit()" placeholder="Responsável" class="form-control input-md" required type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label" for="cnpj">CNPJ</label>
                        <div class="col-md-2">
                            <input id="cnpj" name="cnpj" disabled placeholder="Apenas números" pattern="[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2}" onchange="desabilitaEdit()" value="'.$dados["cnpj"].'" class="form-control input-md" required type="text" maxlength="14">
                        </div>  
                        <label class="col-md-1 control-label" for="email">Email</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                                <input id="email" name="email" value="'.$dados["email"].'" onchange="desabilitaEdit()" class="form-control" disabled placeholder="email@email.com" required type="email" >
                            </div>
                        </div>
                    </div>
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
                                <input id="tel" name="tel" value="'.$dados["telefone"].'" pattern="\d{4}-\d{4}" onchange="desabilitaEdit()" class="form-control" disabled placeholder="XXXX-XXXX" type="tel" maxlength="9">
                            </div>
                        </div>
                    </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cep">CEP</label>
                    <div class="col-md-2">
                        <input id="cep" name="cep" placeholder="Apenas números" onchange="desabilitaEdit()" value="'.$dados["cep"].'" disabled class="form-control input-md" type="search" maxlength="10">
                    </div>
                    <div class="col-md-2">
                            <button type="button" id="pesquisar" class="btn-primary" disabled onclick="getEndereco()">Pesquisar</button>
                    </div>
                </div>
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
                        <button id="atualizar" class="btn btn-success btn_fim" disabled type="Submit">Atualizar</button>
                        <button id="editar" class="btn btn-primary btn_fim" type="button" onclick="editarCampos()">Editar campos</button>
                        <a href="#confirmDelete" data-toggle="modal"><button id="excluir" class="btn btn-danger btn_fim" type="button">Excluir cliente</button></a>
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