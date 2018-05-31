<?php
require_once '../check.php';
require_once '../conexao.php';

if(isset($_POST['pessoa'])) {
    if($_POST['pessoa'] == 'PF') {
        //Pessoa física
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $dtnasc = $_POST['dtnasc'];
        $sexo = $_POST['sexo'];
        $ddd = $_POST['ddd'];
        $tel = $_POST['tel'];
        $mail = $_POST['email'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $uf = $_POST['uf'];
        if(empty($_POST['compl'])) {
            $compl = $_POST['compl'];
        }
        if(empty($_POST['numero'])) {
            $num = $_POST['numero'];
        }

        $sql = "INSERT INTO tb_endereco (logradouro, cidade, bairro, uf, numero, complemento) VALUES (?,?,?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $logradouro);
        $stmt->bindValue(2, $cidade);
        $stmt->bindValue(3, $bairro);
        $stmt->bindValue(4, $uf);
        $stmt->bindValue(5, $num);
        $stmt->bindValue(6, $compl);

        if( $stmt->execute() ) {
            $id_end = $conex->lastInsertId();

            $sql = "INSERT INTO tb_clientes_pf (nome, cpf, telefone, dt_nasc, fk_ddd, sexo, email, fk_endereco) VALUES (?,?,?,?,?,?,?,?);";

            $stmt = $conex->prepare($sql);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $cpf);
            $stmt->bindValue(3, $tel);
            $stmt->bindValue(4, $dtnasc);
            $stmt->bindValue(5, $ddd);
            $stmt->bindValue(6, $sexo);
            $stmt->bindValue(7, $mail);
            $stmt->bindValue(8, $id_end);

            if ($stmt->execute()) {
                $_SESSION['recado'] = 'adicionado';
                header('Location: cadastro.php');
            } else {
                $_SESSION['recado'] = 'erroadicao';
                header('Location: cadastro.php');
            }
        } else {
            $_SESSION['recado'] = 'erroadicao';
            header('Location: cadastro.php');
        }

    } else {
        // pessoa juridica
        $nome = $_POST['nome'];
        $cnpj = $_POST['cnpj'];
        $resp = $_POST['resp'];
        $ddd = $_POST['ddd'];
        $tel = $_POST['tel'];
        $mail = $_POST['email'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $uf = $_POST['uf'];
        if(empty($_POST['compl'])) {
            $compl = $_POST['compl'];
        }
        if(empty($_POST['numero'])) {
            $num = $_POST['numero'];
        }

        $sql = "INSERT INTO tb_endereco (logradouro, cidade, bairro, uf, numero, complemento) VALUES (?,?,?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $logradouro);
        $stmt->bindValue(2, $cidade);
        $stmt->bindValue(3, $bairro);
        $stmt->bindValue(4, $uf);
        $stmt->bindValue(5, $num);
        $stmt->bindValue(6, $compl);

        if( $stmt->execute() ) {
            $id_end = $conex->lastInsertId();

            $sql = "INSERT INTO tb_fornecedor (nome, email, razao_soc, cnpj, fk_ddd, telefone) VALUES (?,?,?,?,?,?);";

            $stmt = $conex->prepare($sql);
            $stmt->bindValue(1, $nome);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $rz);
            $stmt->bindValue(4, $cnpj);
            $stmt->bindValue(5, $ddd);
            $stmt->bindValue(6, $tel);

            if( $stmt->execute() ){
                $_SESSION['recado'] = 'adicionado';
                header('Location: cadastro.php');
            } else {
                $_SESSION['recado'] = 'erroadicao';
                header('Location: cadastro.php');

            }
        } else {
            $_SESSION['recado'] = 'erroadicao';
            header('Location: fornecedores.php');
        }
    }

} else {
    //Retornar ao login, pois não tem acesso.
    echo "errou";
}
