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
    <link href="../css/fornecedores.css" rel="stylesheet">

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
<!--Página que mostra os usuários -->
<div class="container">
    <div class="table-wrapper">
        <div class="table-title">
            <div class="row">
                <a href="../menuprincipal.php">
                    <img src="../img/cables.png/" class="img-logo-usuario"/>
                </a>
                <a href="../menuprincipal.php" class="btn btn-success-retorn btn_ini">
                    <span><i class="fa fa-arrow-circle-left"></i> Voltar ao menu</span>
                </a>
                <a href="#addEmployeeModal" class="btn btn-success btn_ini" data-toggle="modal">
                    <i class="material-icons">&#xE147;</i>
                    <span>Novo fornecedor</span>
                </a>
                <div class="col-sm-6">
                    <?php
                    if ($_SESSION['recado'] == 'deletado') {?>
                        <div class="alert alert-success">
                            <strong>Excluído! </strong>O fornecedor foi removido com sucesso!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'nodelete') {?>
                        <div class="alert alert-danger">
                            <strong>Algo deu errado. </strong>Ocorreu um erro ao excluir o fornecedor.
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'adicionado') {?>
                        <div class="alert alert-success">
                            <strong>Adicionado! </strong>O fornecedor foi adicionado com sucesso!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'erroadicao') {?>
                        <div class="alert alert-warning">
                            <strong>Algo deu errado. </strong>Ocorreu um erro ao adicionar o fornecedor!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'editado') {?>
                        <div class="alert alert-success">
                            <strong>Modificado! </strong>As informações foram alteradas com sucesso!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'erroedicao') {?>
                        <div class="alert alert-danger">
                            <strong>Algo deu errado. </strong>Ocorreu um erro ao modificar as informações do fornecedor!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php }
                    $_SESSION['recado'] = 'vazio';
                    ?>
                </div>
            </div>
        </div>
        <table class="table table-striped table-hover" id="usuariotable">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Razão Social</th>
                <th>CNPJ</th>
                <th>E-mail</th>
                <th>DDD</th>
                <th>Telefone</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = 'SELECT ddd FROM tb_ddd;';
            $ddds = $conex->prepare($sql);
            $ddds->execute();
            while ($n = $ddds->fetch()) {
                $myddds[] = $n['ddd'];
            };
            $qntd = 0;
            // Definindo a quantidade de usuários por página
            $limite = 5;
            // definindo a paginação
            $pg = (isset($_GET['page'])) ? $_GET['page'] : 1;
            // Definindo qual será o ínicio
            $inicio = ($pg * $limite) - $limite;
            // Fazendo a vizualização dos dados
            $sql = 'SELECT * FROM view_fornecedores ORDER BY nome ASC LIMIT '.$inicio.','. $limite.';';
            $prepara = $conex->prepare($sql);
            $prepara->execute();
            while ( $row = $prepara->fetch() ) {
                $id = $row['pk_fornecedor'];
                $nome = $row['nome'];
                $email = $row['email'];
                $rz = $row['razao_soc'];
                $ddd = $row['ddd'];
                $tel = $row['telefone'];
                $cnpj = $row['cnpj'];
                echo '
                        <tr>
                            <td>' . $nome . '</td>
                            <td>' . $rz . '</td>
                            <td>' . $cnpj . '</td>
                            <td>' . $email . '</td>
                            <td>' . $ddd . '</td>
                            <td>' . $tel . '</td>
                            <td>
                                <a href="#editUsuario' . $id . '" class="editar" data-toggle="modal">
                                     <i class="material-icons" data-toggle="tooltip" title="Editar">&#xE254;</i>
                                </a>
                                <a href="#deleteUsuario' . $id . '" class="excluir" data-toggle="modal")>
                                    <i class="material-icons" data-toggle="tooltip" title="Excluir">&#xE872;</i>
                                </a>    
                            </td>
                        </tr>
                        <!-- EditUsuario HTML -->
                        <div id="editUsuario' . $id . '" class="modal fade editar">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="update.pf.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Editar fornecedor</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Nome</label>
                                                <input type="text" name="nome" class="form-control" value="' . $nome . '" required onchange="habilitaSave()">
                                            </div>
                                             <div class="form-group">
                                                <label>Razão Social</label>
                                                <input type="text" name="razao" class="form-control" value="' . $rz . '" required onchange="habilitaSave()">
                                            </div>
                                            <div class="form-group">
                                                <label>CNPJ</label>
                                                <input type="text" name="cnpj" class="form-control" value="' . $rz . '" required onchange="habilitaSave()">
                                            </div>
                                            <div class="form-group">
                                                <label>E-mail</label>
                                                <input type="email" name="email" class="form-control" value="' . $email . '" required onchange="habilitaSave()">
                                            </div>
                                            <div class="form-group">
                                                <label>DDD</label>
                                                <select class="form-control" required name="ddd"  onchange="habilitaSave()">';
                for($i = 0; $i < count($myddds); ++$i) {
                    if($myddds[$i] == $ddd) {
                        echo '<option selected>'.$myddds[$i].'</option>';
                    } else {
                        echo '<option>'.$myddds[$i].'</option>';
                    }
                }
                echo '
                                                </select>
                                                <input name="id" type="hidden" value="' . $id . '" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                            <input type="submit" class="btn btn-info save" value="Salvar" disabled>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- DeleteUsuario HTML -->
                        <div id="deleteUsuario' . $id . '" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="delete.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Excluir fornecedor</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <b><p>Deseja excluir o fornecedor ' . $nome .'?</p></b>
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
                $qntd = $qntd + 1;
            }
            // Verificando quantos itens existem na tabela
            $sql_Total = 'SELECT pk_fornecedor FROM tb_fornecedor';
            $query_Total = $conex->prepare($sql_Total);
            $query_Total->execute();
            $query_result = $query_Total->fetchAll(PDO::FETCH_ASSOC);
            $query_count =  $query_Total->rowCount(PDO::FETCH_ASSOC);
            // Colocando na variavel quantas páginas vão existir
            $qtdPag = ceil($query_count/$limite);
            $pagina_anterior = $pg -1;
            $pagina_posterior = $pg +1;?>
            </tbody>
        </table>
        <!--    apresentar a paginação-->
        <div class="clearfix">
            <?php echo'<div class="hint-text">Mostrando <b>'. $qntd .'</b> de <b>'. $query_count .'</b> registros</div>';?>
            <ul class="pagination">
                <?php
                if($pagina_anterior != 0) {
                    echo '
                                <li class="page-item"><a href="fornecedores.php?page='. $pagina_anterior .'">Anterior</a></li>';
                } else {
                    echo '
                                <li class="page-item disabled"><a href="#">Anterior</a></li>';
                };
                if($qtdPag > 1 && $pg <= $qtdPag){
                    for($i = 1; $i <= $qtdPag; $i++){
                        if($i == $pg){
                            echo "
                                        <li class=\"page-item active\"><a href=\"#\" class=\"page-link\">" . $i. "</a></li>";
                        } else {
                            echo '
                                        <li class=\"page-item disabled\"><a href="fornecedores.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                        }
                    }
                }if($pagina_posterior <= $qtdPag) {
                    echo '
                                <li class="page-item"><a href="fornecedores.php?page='.$pagina_posterior.'" class="page-link">Próxima</a></li>';
                } else {
                    echo '
                                <li class="page-item disabled"><a href="#" class="page-link">Próxima</a></li>';
                };?>
            </ul>
        </div>
    </div>
</div>

<!-- AdicionarUsuario HTML -->
<div id="addEmployeeModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="create.php">
                <div class="modal-header">
                    <h4 class="modal-title">Adicionar fornecedor</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Fornecedor</label>
                        <input type="text" class="form-control" name="nome" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>Razão Social</label>
                        <input type="text" class="form-control" name="razao_soc" required>
                    </div>
                    <div class="form-group">
                        <label>CNPJ</label>
                        <input type="text" maxlength="14" class="form-control cpf-mask" name="cnpj" required>
                    </div>
                    <div class="form-group">
                        <label>E-mail</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>DDD</label>
                        <select class="form-control" required name="ddd">
                            <option></option>
                            <?php for($i = 0; $i < count($myddds); ++$i) {
                                echo '<option>'.$myddds[$i].'</option>';
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="tel" maxlength="8" class="form-control" name="tel" required>
                    </div>
                    <div class="form-group">
                        <label>Produtos</label>
                        <input type="text" class="form-control" id="prod" name="produtos" placeholder="Pesquise pelo nome ou código do produto">
                    </div>
                    <div class="mytab">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>Código</th>
                                <th>Produto</th>
                                <th>Remover</th>
                            </thead>
                            <tbody>
                                <tr class="linha">
                                    <td id="codigo" class="cod"></td>
                                    <td id="nome_prod" class="produtos"></td>
                                    <td class="excluir" id="exclui" onclick="apagaLinha(this)"><i class="glyphicon glyphicon-remove"></i></td>
                                </tr>
                                <tr id="novalinha"></tr>
                            </tbody>
                        </table>
                        <input type="hidden" id="codigos" name="codigos">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                    <input type="submit" class="btn btn-success" id="adicionar" value="Adicionar" onclick="registraProds()">
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/fornecedores.js"></script>
</body>
</html>