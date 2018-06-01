<?php
require_once '../conexao.php';
require_once '../check.php';
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
    <link href="../css/clientes.css" rel="stylesheet">

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
</head>
<body>
<!--Página que mostra os usuários -->
<div class="container">
    <div class="table-wrapper">
        <div class="table-title fisica">
            <div class="row">
                <div class="col-sm-6">
                    <a href="../menuprincipal.php">
                        <img src="../img/cables.png/" class="img-logo-usuario"/>
                    </a>
                    <?php
                    if ($_SESSION['recado'] == 'deletado') {?>
                        <div class="alert alert-success">
                            <strong>Excluído! </strong>O produto foi removido com sucesso!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'nodelete') {?>
                        <div class="alert alert-danger">
                            <strong>Algo deu errado. </strong>Ocorreu um erro ao excluir o produto.
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'quantidade') {?>
                        <div class="alert alert-danger">
                            <strong>Ops! </strong>Não podemos excluir um produto que ainda está disponível em estoque.
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'adicionado') {?>
                        <div class="alert alert-success">
                            <strong>Adicionado! </strong>O novo produto foi adicionado com sucesso!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'erroadicao') {?>
                        <div class="alert alert-warning">
                            <strong>Algo deu errado. </strong>Ocorreu um erro ao adicionar este produto!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'editado') {?>
                        <div class="alert alert-success">
                            <strong>Modificado! </strong>As informações foram alteradas com sucesso!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php } elseif($_SESSION['recado'] == 'erroedicao') {?>
                        <div class="alert alert-danger">
                            <strong>Algo deu errado. </strong>Ocorreu um erro ao modificar os dados deste produto!
                            <button class="close" data-dismiss="alert">x</button>
                        </div>
                    <?php }
                    $_SESSION['recado'] = 'vazio';
                    ?>
                </div>
                <div class="col-sm-6">
                    <a href="../menuprincipal.php" class="btn btn-success-retorn">
                        <span><i class="fa fa-home" style="font-size:20px;"></i> Ir ao menu</span>
                    </a>
                    <a href="cadastro.php" class="btn btn-success">
                        <i class="fa fa-arrow-circle-left"></i>
                        <span>Voltar ao cadastro</span>
                    </a>
                </div>
            </div>
        </div>
            <div class="col-md-3 bar">
                <div class="btn-group btn-group-justified">
                    <a class="btn btn-default active" id="show-pf" href="#" onclick="tipoPessoaFis()">Pessoa Física</a>
                    <a class="btn btn-default" id="show-pj" href="#" onclick="tipoPessoaJur()">Pessoa Jurídica</a>
                </div>
            </div>
            <div class="col-md-3 bar">
                <input type="search" placeholder="Pesquisar cliente" id="seacrch" class="form-control">
            </div>
        <div id="fisica">
        <table class="table table-striped table-hover" id="usuariotable">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $qntd = 0;
            // Definindo a quantidade de usuários por página
            $limite = 5;
            // definindo a paginação
            $pg = (isset($_GET['page'])) ? $_GET['page'] : 1;
            // Definindo qual será o ínicio
            $inicio = ($pg * $limite) - $limite;
            // Fazendo a vizualização dos dados
            $sql = 'SELECT pk_clie_pf, nome, cpf FROM tb_clientes_pf ORDER BY nome ASC LIMIT '.$inicio.','. $limite.';';
            $prepara = $conex->prepare($sql);
            $prepara->execute();
            while ( $row = $prepara->fetch() ) {
                $id = $row['pk_clie_pf'];
                $nome = $row['nome'];
                $cpf = $row['cpf'];
                $cod = base64_encode($id);
                echo '
                        <tr>
                            <td>' . $nome . '</td>  
                            <td>' . $cpf . '</td>
                            <td>
                                <a href="viewer.php?view=' . $cod . '" class="vizualizar" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Vizualizar">&#xe85d;</i>
                                </a>
                                <a href="#deleteClientePF' . $id . '" class="excluir" data-toggle="modal")>
                                    <i class="material-icons" data-toggle="tooltip" title="Excluir">&#xE872;</i>
                                </a>    
                            </td>
                        </tr>
                        <!-- DeleteUsuario HTML -->
                        <div id="deleteClientePF' . $id . '" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="delete.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Excluir produto</h4>
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
                $qntd = $qntd + 1;
            }
            // Verificando quantos itens existem na tabela
            $sql_Total = 'SELECT pk_clie_pf FROM tb_clientes_pf';
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
                                <li class="page-item"><a href="clientes.php?page='. $pagina_anterior .'">Anterior</a></li>';
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
                                        <li class=\"page-item disabled\"><a href="clientes.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                        }
                    }
                }if($pagina_posterior <= $qtdPag) {
                    echo '
                                <li class="page-item"><a href="clientes.php?page='.$pagina_posterior.'" class="page-link">Próxima</a></li>';
                } else {
                    echo '
                                <li class="page-item disabled"><a href="#" class="page-link">Próxima</a></li>';
                };?>
            </ul>
        </div>
        </div>
        <div id="juridica">
            <table class="table table-striped table-hover" id="usuariotable">
                <thead>
                <tr>
                    <th>Nome</th>
                    <th>CNPJ</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $qntd_pj = 0;
                // Definindo a quantidade de usuários por página
                // definindo a paginação
                $pg = (isset($_GET['page'])) ? $_GET['page'] : 1;
                // Definindo qual será o ínicio
                $inicio_pj = ($pg * $limite) - $limite;
                // Fazendo a vizualização dos dados
                $sql = 'SELECT pk_cliente_pj, razao_soc, cnpj FROM tb_cliente_pj ORDER BY razao_soc ASC LIMIT '.$inicio.','. $limite.';';
                $prepara = $conex->prepare($sql);
                $prepara->execute();
                while ( $row = $prepara->fetch() ) {
                    $id = $row['pk_cliente_pj'];
                    $rz = $row['razao_soc'];
                    $cnpj = $row['cnpj'];
                    echo '
                        <tr>
                            <td>' . $rz . '</td>  
                            <td>' . $cnpj . '</td>
                            <td>
                                <a href="viewer.php?' . $id . '" class="vizualizar" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Vizualizar">&#xe85d;</i>
                                </a>
                                <a href="#deleteClientePJ' . $id . '" class="excluir" data-toggle="modal")>
                                    <i class="material-icons" data-toggle="tooltip" title="Excluir">&#xE872;</i>
                                </a>    
                            </td>
                        </tr>
                        <!-- DeleteUsuario HTML -->
                        <div id="deleteClientePJ' . $id . '" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="delete.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Excluir produto</h4>
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
                    $qntd_pj = $qntd_pj + 1;
                }
                // Verificando quantos itens existem na tabela
                $sql_Total = 'SELECT pk_cliente_pj FROM tb_cliente_pj;';
                $query_Total = $conex->prepare($sql_Total);
                $query_Total->execute();
                $query_resulta = $query_Total->fetchAll(PDO::FETCH_ASSOC);
                $query_counte =  $query_Total->rowCount(PDO::FETCH_ASSOC);
                // Colocando na variavel quantas páginas vão existir
                $qtdPagn = ceil($query_count/$limite);
                $paginaAnterior = $pg -1;
                $paginaPosterior = $pg +1;?>
                </tbody>
            </table>
            <!--    apresentar a paginação-->
            <div class="clearfix">
                <?php echo'<div class="hint-text">Mostrando <b>'. $qntd_pj .'</b> de <b>'. $query_counte .'</b> registros</div>';?>
                <ul class="pagination">
                    <?php
                    if($paginaAnterior != 0) {
                        echo '
                                <li class="page-item"><a href="clientes.php?page='. $paginaAnterior .'">Anterior</a></li>';
                    } else {
                        echo '
                                <li class="page-item disabled"><a href="#">Anterior</a></li>';
                    };
                    if($qtdPagn > 1 && $pg <= $qtdPagn){
                        for($i = 1; $i <= $qtdPagn; $i++){
                            if($i == $pg){
                                echo "
                                        <li class=\"page-item active\"><a href=\"#\" class=\"page-link\">" . $i. "</a></li>";
                            } else {
                                echo '
                                        <li class=\"page-item disabled\"><a href="clientes.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                            }
                        }
                    }if($paginaPosterior <= $qtdPagn) {
                        echo '
                                <li class="page-item"><a href="clientes.php?page='.$paginaPosterior.'" class="page-link">Próxima</a></li>';
                    } else {
                        echo '
                                <li class="page-item disabled"><a href="#" class="page-link">Próxima</a></li>';
                    };?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="../js/clientes.js"></script>
</body>
</html>