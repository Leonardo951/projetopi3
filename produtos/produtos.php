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

        <!-- Custom styles for this template -->
        <link href="../css/produtos.css" rel="stylesheet">

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
    </head>
    <body>
        <!--Página que mostra os usuários -->
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <a href="../index.php">
                            <img src="../img/cables.png/" class="img-logo-usuario"/>
                        </a>
                        <a href="../index.php" class="btn btn-success-retorn btn_ini">
                            <span><i class="fa fa-arrow-circle-left"></i> Voltar ao menu</span>
                        </a>
                        <a href="#addEmployeeModal" class="btn btn-success btn_ini" data-toggle="modal">
                            <i class="material-icons">&#xE147;</i>
                            <span>Novo produto</span>
                        </a>
                        <?php
                        if(base64_decode($_SESSION['user']) != 'Vendedor'){
                            echo '
                            <a href="#addCompra" class="btn btn-primary btn_ini" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i>
                                <span>Registrar compra</span>
                            </a>';
                        }
                        ?>
                        <div class="col-sm-6">
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
                            <?php } elseif($_SESSION['recado'] == 'compraadd') {?>
                                <div class="alert alert-success">
                                    <strong>Registrado! </strong>Compra registrada com sucesso!
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php } elseif($_SESSION['recado'] == 'compraerro') {?>
                                <div class="alert alert-danger">
                                    <strong>Algo deu errado. </strong>Ocorreu um erro ao registrar a compra!
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
                            <th>Código</th>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th>Marca</th>
                            <th>Quantidade disponível</th>
                            <th>Preço (R$)</th>
                            <th>Fornecedores</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = 'SELECT categoria FROM tb_categoria;';
                    $c = $conex->prepare($sql);
                    $c->execute();
                    while ($cat = $c->fetch()) {
                        $mycateg[] = $cat['categoria'];
                    };
                    $qntd = 0;
                    // Definindo a quantidade de usuários por página
                    $limite = 5;
                    // definindo a paginação
                    $pg = (isset($_GET['page'])) ? $_GET['page'] : 1;
                    // Definindo qual será o ínicio
                    $inicio = ($pg * $limite) - $limite;
                    // Fazendo a vizualização dos dados
                    $sql = 'SELECT * FROM view_produtos ORDER BY nome_prod ASC LIMIT '.$inicio.','. $limite.';';
                    $prepara = $conex->prepare($sql);
                    $prepara->execute();
                    while ( $row = $prepara->fetch() ) {
                        $id = $row['pk_prod'];
                        $cod_prod = $row['cod_prod'];
                        $prod = $row['nome_prod'];
                        $preco = $row['preco'];
                        $estoque = $row['qntd_estoq'];
                        $categoria = $row['categoria'];
                        $marca = $row['marca'];
                        echo '
                        <tr>
                            <td>' . $cod_prod . '</td>
                            <td>' . $prod . '</td>  
                            <td>' . $categoria . '</td>
                            <td>' . $marca . '</td>
                            <td>' . $estoque . '</td>
                            <td>' . number_format($preco, 2, ',', '.') . '</td>
                            <td>
                                <a href="../fornecidos/prod-fornecidos.php?produto='. $cod_prod .'" target=“_blank” class="forn" data-toggle="modal">Visualizar</a>
                            </td>
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
                                            <h4 class="modal-title">Editar informações produto</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Produto</label>
                                                <input type="text" name="prod" class="form-control" value="' . $prod . '" required onchange="habilitaSave()">
                                            </div>
                                            <div class="form-group">
                                                <label>Categoria</label>
                                                <select class="form-control" required name="cat" onchange="habilitaSave()">';
                                                    for($i = 0; $i < count($mycateg); ++$i) {
                                                        if($mycateg[$i] == $categoria) {
                                                            echo '<option selected>'.$mycateg[$i].'</option>';
                                                        } else {
                                                            echo '<option>'.$mycateg[$i].'</option>';
                                                        }
                                                    }
                                                    echo '
                                                </select>
                                                <input name="id" type="hidden" value="' . $id . '" />
                                            </div>
                                            <div class="form-group">
                                                <label>Marca</label>
                                                <input type="text" name="marca" class="form-control" value="' . $marca . '" required onchange="habilitaSave()">
                                            </div>
                                            <div class="form-group">
                                                <label>Preço</label>
                                                <input type="text" name="preco" class="form-control" value="' . $preco . '" required onchange="habilitaSave()">
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
                                            <h4 class="modal-title">Excluir produto</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <b><p>Deseja realmente excluir este produto?</p></b>
                                            <p class="text-warning"><small>Para excluir quantidade disponível deve ser igual a 0.</small></p>
                                            <p class="text-warning"><small>Essa ação não poderá ser desfeita...</small></p>
                                            <input name="id" type="hidden" value="' . $id . '" />
                                            <input name="qntd" type="hidden" value="' . $estoque . '" />
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
                    $sql_Total = 'SELECT pk_prod FROM tb_produto';
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
                                <li class="page-item"><a href="produtos.php?page='. $pagina_anterior .'">Anterior</a></li>';
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
                                        <li class=\"page-item disabled\"><a href="produtos.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                                }
                            }
                        }if($pagina_posterior <= $qtdPag) {
                            echo '
                                <li class="page-item"><a href="produtos.php?page='.$pagina_posterior.'" class="page-link">Próxima</a></li>';
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
                    <form method="POST" action="insert.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Adicionar novo produto</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Produto</label>
                                <input type="text" class="form-control" name="prod" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>Categoria</label>
                                <select class="form-control" required name="cat">
                                    <option></option>
                                    <?php for($i = 0; $i < count($mycateg); ++$i) {
                                        echo '<option>'.$mycateg[$i].'</option>';
                                    } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" class="form-control" name="marca" required>
                            </div>
                            <div class="form-group">
                                <label>Preço</label>
                                <input type="text" class="form-control" name="preco" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-success" value="Adicionar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal de nova compra HTML -->
        <div id="addCompra" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="novaCompra.php">
                        <div class="modal-header">
                            <h4 class="modal-title">Registrar compra</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Produto</label>
                                <input type="text" class="form-control" id="prod" name="prod" required autofocus placeholder="Pesquise pelo nome ou código do produto" onchange="buscaDados()">
                            </div>
                            <div class="form-group">
                                <label>Categoria</label>
                                <input type="text" readonly class="form-control" required name="cat" id="categoria">
                                <input type="hidden" id="fk-cat" name="fk_cat">
                                <input type="hidden" id="pk" name="pk_prod">
                            </div>
                            <div class="form-group">
                                <label>Marca</label>
                                <input type="text" class="form-control" name="marca" required id="marca" readonly>
                            </div>
                            <div class="form-group">
                                <label>Fornecedor</label>
                                <input type="text" class="form-control" name="fornecedor" id="forn" placeholder="Pesquise pelo nome ou CNPJ da empresa" required>
                            </div>
                            <div class="form-group">
                                <label>Valor da compra</label>
                                <input type="text" class="form-control" name="valor" required>
                            </div>
                            <div class="form-group">
                                <label>Quantidade</label>
                                <input type="number" class="form-control" name="qnt" required min="1" value="1">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-success" value="Adicionar">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <script type="text/javascript" src="../js/produtos.js"></script>
    </body>
</html>