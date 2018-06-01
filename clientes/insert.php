<?php
require_once '../check.php';
require_once '../conexao.php';
require_once '../functions/limpar.php';

//Verificando se a pessoa na página preencheu o formulário
if(isset($_POST['pessoa'])) {
    //Inserindo Endereco no banco de dados
    $cep = limpa($_POST['cep']);
    $logradouro = $_POST['logradouro'];
    $cidade = $_POST['cidade'];
    $bairro = $_POST['bairro'];
    $uf = $_POST['estado'];
    if (isset($_POST['compl'])) {
        $compl = $_POST['compl'];
    }
    if (isset($_POST['numero'])) {
        $num = $_POST['numero'];
    }
    if (isset($num) && isset($compl)) {
        $sql = "INSERT INTO tb_endereco (logradouro, cidade, bairro, uf, numero, complemento, cep) VALUES (?,?,?,?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $logradouro);
        $stmt->bindValue(2, $cidade);
        $stmt->bindValue(3, $bairro);
        $stmt->bindValue(4, $uf);
        $stmt->bindValue(5, $num);
        $stmt->bindValue(6, $compl);
        $stmt->bindValue(7, $cep);
    } elseif (isset($num)) {
        $sql = "INSERT INTO tb_endereco (logradouro, cidade, bairro, uf, cep, numero) VALUES (?,?,?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $logradouro);
        $stmt->bindValue(2, $cidade);
        $stmt->bindValue(3, $bairro);
        $stmt->bindValue(4, $uf);
        $stmt->bindValue(5, $cep);
        $stmt->bindValue(6, $num);
    } elseif (isset($compl)) {
        $sql = "INSERT INTO tb_endereco (logradouro, cidade, bairro, uf, cep, complemento) VALUES (?,?,?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $logradouro);
        $stmt->bindValue(2, $cidade);
        $stmt->bindValue(3, $bairro);
        $stmt->bindValue(4, $uf);
        $stmt->bindValue(5, $cep);
        $stmt->bindValue(6, $compl);
    } else {
        $sql = "INSERT INTO tb_endereco (logradouro, cidade, bairro, uf) VALUES (?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $logradouro);
        $stmt->bindValue(2, $cidade);
        $stmt->bindValue(3, $bairro);
        $stmt->bindValue(4, $uf);
    }
    if ($stmt->execute()) {
        $id_end = $conex->lastInsertId();
        if ($_POST['pessoa'] == 'PF') {
            //Pessoa física
            $nome = $_POST['nome'];
            $cpf = limpa($_POST['cpf']);
            $dtnasc = implode("-", array_reverse(explode("/", $_POST['dtnasc'])));
            $sexo = $_POST['sexo'];
            $ddd = $_POST['ddd'];
            $tel = limpa($_POST['tel']);
            $mail = $_POST['email'];
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
                $sql = "DELETE FROM tb_endereco WHERE pk_endereco = :pk_endereco;";
                $stmt = $conex->prepare($sql);
                $stmt->bindParam(':pk_endereco', $id_end);
                $stmt->execute();
                header('Location: cadastro.php');
            }
        } else {
            // pessoa juridica
            $empresa = $_POST['empresa'];
            $cnpj = limpa($_POST['cnpj']);
            $resp = $_POST['resp'];
            $ddd = $_POST['ddd_pj'];
            $tel = limpa($_POST['tel_pj']);
            $mail = $_POST['mail'];
            $rz = $_POST['razao_soc'];

            $sql = "INSERT INTO tb_cliente_pj (empresa, email, razao_soc, cnpj, fk_ddd, telefone, fk_endereco, responsavel) VALUES (?,?,?,?,?,?,?,?);";


            $stmt = $conex->prepare($sql);
            $stmt->bindValue(1, $empresa);
            $stmt->bindValue(2, $mail);
            $stmt->bindValue(3, $rz);
            $stmt->bindValue(4, $cnpj);
            $stmt->bindValue(5, $ddd);
            $stmt->bindValue(6, $tel);
            $stmt->bindValue(7, $id_end);
            $stmt->bindValue(8, $resp);

            if ($stmt->execute()) {
                $_SESSION['recado'] = 'adicionado';
                header('Location: cadastro.php');
            } else {
                $_SESSION['recado'] = 'erroadicao';
                $sql = "DELETE FROM tb_endereco WHERE pk_endereco = :pk_endereco;";
                $stmt = $conex->prepare($sql);
                $stmt->bindParam(':pk_endereco', $id_end);
                $stmt->execute();
                header('Location: cadastro.php');
            }
        }

    } else {
        $_SESSION['recado'] = 'erroadicao';
        header('Location: cadastro.php');
    }
}