<?php
require_once '../conexao.php';
require_once '../functions/check.php';
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
    <link href="../css/relVendas.css" rel="stylesheet">

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

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.3.1/jquery.quicksearch.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

</head>
<body>
<!--Página que mostra os usuários -->
<div class="container">
    <div class="table-wrapper">
        <div class="table-title fisica">
            <div class="row">
                <a href="../index.php">
                    <img src="../img/cables.png/" class="img-logo-usuario"/>
                </a>
                <a href="../index.php" class="btn btn-success-retorn btn_ini">
                    <span><i class="fa fa-home" style="font-size:20px;"></i> Ir ao menu</span>
                </a>
                <a href="venda.php" class="btn btn-success btn_ini">
                    <i class="material-icons">&#xE147;</i>
                    <span>Registrar venda</span>
                </a>
            </div>
        </div>
        <div class="col-md-3 bar">
            <div class="btn-group btn-group-justified">
                <a class="btn btn-default active" id="show-pf" href="#" onclick="tipoPessoaFis()">Cliente PF</a>
                <a class="btn btn-default" id="show-pj" href="#" onclick="tipoPessoaJur()">Cliente PJ</a>
            </div>
        </div>
        <div class="col-md-3 bar">
            <div class="input-group">
                <span class="input-group-addon"><i class="	glyphicon glyphicon-search"></i></span>
                <input id="input-search" name="search" class="form-control" placeholder="Pesquisar código da venda" type="search" title="Pesquisar">
            </div>
        </div>
        <div id="fisica">
            <table class="table table-striped table-hover" id="usuariotable" title="Pesquisar">
                <thead>
                <tr>
                    <th>N° venda</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Valor</th>
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
                $sql = 'SELECT * FROM view_vendas_pf ORDER BY nome ASC LIMIT '.$inicio.','. $limite.';';
                $prepara = $conex->prepare($sql);
                $prepara->execute();
                while ( $row = $prepara->fetch() ) {
                    $cod_venda = $row['cod_venda'];
                    $cliente = $row['nome'];
                    $vendedor = $row['nome_usuario'];
                    $valor = $row['vl_total'];
                    $dt_hr = $into["dt_hr_venda"];
                    $dt_agora = new DateTime();
                    $dt_venda = new DateTime($dt_hr);
                    $res = $dt_agora->diff($dt_venda);
                    $res->format('%d');
                    $tempo = intval($res);
                    echo '
                        <tr>
                            <td>' . $cod_venda . '</td>  
                            <td>' . $cliente . '</td>
                            <td>' . $vendedor . '</td>
                            <td>' . $valor . '</td>
                            <td>
                                <a href="viewer.php?venda=' . $cod_venda . '" class="vizualizar" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Vizualizar">&#xe85d;</i>
                                </a>';
                    if($tempo <= 7){
                        echo'
                                <a href="#deleteClientePF' . $cod_venda . '" class="excluir" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Excluir">&#xE872;</i>
                                </a>
                                <!-- DeleteUsuario HTML -->
                        <div id="deleteClientePF\' . $cod_venda . \'" class="modal fade">
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
                                        <input name="venda" type="hidden" value="\' . $cod_venda . \'" />
                                    </div>
                                    <div class="modal-footer">
                                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                            <input type="submit" class="btn btn-danger" value="Excluir">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>';
                    }
                    echo '
                            </td>
                        </tr>';
                    $qntd = $qntd + 1;
                }
                // Verificando quantos itens existem na tabela
                $sql_Total = 'SELECT * FROM view_vendas_pf';
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
                                <li class="page-item"><a href="relVendas.php?page='. $pagina_anterior .'">Anterior</a></li>';
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
                                        <li class=\"page-item disabled\"><a href="relVendas.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                            }
                        }
                    }if($pagina_posterior <= $qtdPag) {
                        echo '
                                <li class="page-item"><a href="relVendas.php?page='.$pagina_posterior.'" class="page-link">Próxima</a></li>';
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
                    <th>N° venda</th>
                    <th>Cliente</th>
                    <th>Vendedor</th>
                    <th>Valor</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $qntd_pj = 0;
                $lim = 5;
                // Definindo a quantidade de usuários por página
                // definindo a paginação
                $page = (isset($_GET['pg'])) ? $_GET['pg'] : 1;
                // Definindo qual será o ínicio
                $ini = ($page * $lim) - $lim;
                // Fazendo a vizualização dos dados
                $sql = 'SELECT * FROM view_vendas_pj ORDER BY empresa ASC LIMIT '.$ini.','. $lim.';';
                $prepara = $conex->prepare($sql);
                $prepara->execute();
                while ( $row = $prepara->fetch() ) {
                    $id_cod = $row['cod_venda'];
                    $client = $row['empresa'];
                    $resp = $row['responsavel'];
                    $vend = $row['nome_usuario'];
                    $val_venda = $row['vl_total'];
                    echo '
                        <tr>
                            <td>' . $id_cod . '</td>  
                            <td>' . $client . '<br>' . $resp . '</td>
                            <td>' . $vend . '</td>
                            <td>' . $val_venda . '</td>
                            <td>
                                <a href="viewer.php?venda=' . $id_cod . '" class="vizualizar" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Vizualizar">&#xe85d;</i>
                                </a>
                                <a href="#deleteClientePJ' . $id_cod . '" class="excluir" data-toggle="modal">
                                    <i class="material-icons" data-toggle="tooltip" title="Excluir">&#xE872;</i>
                                </a>    
                            </td>
                        </tr>
                        <!-- DeleteUsuario HTML -->
                        <div id="deleteClientePJ' . $id_cod . '" class="modal fade">
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
                                        <input name="venda" type="hidden" value="' . $id_cod . '" />
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
                $sql_Total = 'SELECT * FROM view_vendas_pj;';
                $query_Total = $conex->prepare($sql_Total);
                $query_Total->execute();
                $query_resulta = $query_Total->fetchAll(PDO::FETCH_ASSOC);
                $query_counte =  $query_Total->rowCount(PDO::FETCH_ASSOC);
                // Colocando na variavel quantas páginas vão existir
                $qtdPagn = ceil($query_counte/$limite);
                $paginaAnterior = $page -1;
                $paginaPosterior = $page +1;?>
                </tbody>
            </table>
            <!--    apresentar a paginação-->
            <div class="clearfix">
                <?php echo'<div class="hint-text">Mostrando <b>'. $qntd_pj .'</b> de <b>'. $query_counte .'</b> registros</div>';?>
                <ul class="pagination">
                    <?php
                    if($paginaAnterior != 0) {
                        echo '
                                <li class="page-item"><a href="relVendas.php?page='. $paginaAnterior .'">Anterior</a></li>';
                    } else {
                        echo '
                                <li class="page-item disabled"><a href="#">Anterior</a></li>';
                    };
                    if($qtdPagn > 1 && $page <= $qtdPagn){
                        for($i = 1; $i <= $qtdPagn; $i++){
                            if($i == $page){
                                echo "
                                        <li class=\"page-item active\"><a href=\"#\" class=\"page-link\">" . $i. "</a></li>";
                            } else {
                                echo '
                                        <li class=\"page-item disabled\"><a href="relVendas.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                            }
                        }
                    }if($paginaPosterior <= $qtdPagn) {
                        echo '
                                <li class="page-item"><a href="relVendas.php?page='.$paginaPosterior.'" class="page-link">Próxima</a></li>';
                    } else {
                        echo '
                                <li class="page-item disabled"><a href="#" class="page-link">Próxima</a></li>';
                    };?>
                </ul>
            </div>
        </div>
    </div>
</div>
<script src="../js/search.js" type="text/javascript"></script>
<script src="../js/relVendas.js" type="text/javascript"></script>
</body>
</html>