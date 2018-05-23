<?php
    require_once '../check.php';
    include_once '../conexao.php';
    session_start();
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

        <!-- Bootstrap core CSS -->
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="../css/usuarios.css" rel="stylesheet">

        <script src="../js/ie-emulation-modes-warning.js"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
        <!--Página que mostra os usuários -->
        <div class="container">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="../img/cables.png/" class="img-logo-usuario"/>
                            <?php
                            if ($_SESSION['recado'] == 'deletado') {?>
                                <div class="alert alert-success">
                                    <strong>Excluído! </strong>O usuário foi removido com sucesso!
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php } elseif($_SESSION['recado'] == 'nodelete') {?>
                                <div class="alert alert-danger">
                                    <strong>Algo deu errado. </strong>Ocorreu um erro ao excluir o usuário.
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php } elseif($_SESSION['recado'] == 'adicionado') {?>
                                <div class="alert alert-success">
                                    <strong>Adicionado! </strong>O usuário foi adicionado com sucesso!
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php } elseif($_SESSION['recado'] == 'erroadicao') {?>
                                <div class="alert alert-warning">
                                    <strong>Algo deu errado. </strong>Ocorreu um erro ao adicionar o usuário!
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php } elseif($_SESSION['recado'] == 'editado') {?>
                                <div class="alert alert-success">
                                    <strong>Modificado! </strong>As informações foram alteradas com sucesso!
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php } elseif($_SESSION['recado'] == 'erroedicao') {?>
                                <div class="alert alert-danger">
                                    <strong>Algo deu errado. </strong>Ocorreu um erro ao modificar as informações do usuário!
                                    <button class="close" data-dismiss="alert">x</button>
                                </div>
                            <?php }
                            $_SESSION['recado'] = 'vazio';
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <a href="../menuprincipal.php" class="btn btn-success-retorn">
                                <span><i class="fa fa-arrow-circle-left"></i> Voltar ao menu</span>
                            </a>
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal">
                                <i class="material-icons">&#xE147;</i>
                                <span>Novo usuário</span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover" id="usuariotable">
                    <thead>
                        <tr>
                            <th>Nome do usuário</th>
                            <th>Email</th>
                            <th>Perfil de Acesso</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sql = 'SELECT perfil FROM tb_perfil;';
                    $perf = $conex->prepare($sql);
                    $perf->execute();
                    while ($per = $perf->fetch()) {
                        $myperfs[] = $per['perfil'];
                    };
                    $qntd = 0;
                    // Definindo a quantidade de usuários por página
                    $limite = 5;
                    // definindo a paginação
                    $pg = (isset($_GET['page'])) ? $_GET['page'] : 1;
                    // Definindo qual será o ínicio
                    $inicio = ($pg * $limite) - $limite;
                    // Fazendo a vizualização dos dados
                    $sql = 'SELECT * FROM perfil_usuario ORDER BY nome ASC LIMIT '.$inicio.','. $limite.';';
                    $prepara = $conex->prepare($sql);
                    $prepara->execute();
                    while ( $row = $prepara->fetch() ) {
                        $id = $row['pk_usuario'];
                        $nome = $row['nome'];
                        $email = $row['email'];
                        $perfil = $row['perfil'];
                        echo '
                        <tr>
                            <td>' . $nome . '</td>
                            <td>' . $email . '</td>
                            <td>' . $perfil . '</td>
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
                        <div id="editUsuario' . $id . '" class="modal fade">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="update.php" method="POST">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Editar usuário</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input type="text" name="nome" class="form-control" value="' . $nome . '" required>
                                        </div>
                                        <div class="form-group">
                                            <label>E-mail</label>
                                            <input type="email" name="email" class="form-control" value="' . $email . '" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Perfil de acesso</label>
                                            <select class="form-control" required name="perfil" >';
                                                for($i = 0; $i < count($myperfs); ++$i) {
                                                    if($myperfs[$i] == $perfil) {
                                                        echo '<option selected>'.$myperfs[$i].'</option>';
                                                    } else {
                                                        echo '<option>'.$myperfs[$i].'</option>';
                                                    }
                                                }
                                            echo '
                                        </select>
                                        <input name="id" type="hidden" value="' . $id . '" />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                                    <input type="submit" class="btn btn-info" value="Salvar">
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
                                    <h4 class="modal-title">Excluir usuário</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                </div>
                                <div class="modal-body">
                                    <b><p>Deseja excluir o usuário ' . $nome .'?</p></b>
                                    <p class="text-warning"><small>Essa ação não poderá ser desfeita..</small></p>
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
                $sql_Total = 'SELECT pk_usuario FROM tb_usuario';
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
                        <li class="page-item"><a href="usuarios.php?page='. $pagina_anterior .'">Anterior</a></li>';
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
                                <li class=\"page-item disabled><a href="usuarios.php?page='.$i.'" class=\"page-link\">'. $i  .'</a></li>';
                            }
                        }
                    }if($pagina_posterior <= $qtdPag) {
                        echo '
                        <li class="page-item"><a href="usuarios.php?page='.$pagina_posterior.'" class="page-link">Próxima</a></li>';
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
                            <h4 class="modal-title">Adicionar usuário</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Nome do usuário</label>
                                <input type="text" class="form-control" name="nome" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label>Senha</label>
                                <input type="text" class="form-control" value="p@ssw0rd" name="senha" required>
                            </div>
                            <div class="form-group">
                                <label>Perfil de Acesso</label>
                                <select class="form-control" required name="perfil">
                                    <option></option>
                                    <?php for($i = 0; $i < count($myperfs); ++$i) {
                                        echo '<option>'.$myperfs[$i].'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancelar">
                            <input type="submit" class="btn btn-success" value="Adicionar" onclick="reload();">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>