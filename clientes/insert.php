<?php
require_once '../functions/check.php';
require_once '../conexao.php';
require_once '../functions/limpar.php';

//Verificando se a pessoa na página preencheu o formulário
if(isset($_POST['pessoa'])) {
    if ($_POST['pessoa'] == 'PF') {
        //Pessoa física
        $nome = ucwords(strtolower($_POST['nome']));
        $cpf = limpa($_POST['cpf']);
        $dtnasc = implode("-", array_reverse(explode("/", $_POST['dtnasc'])));
        $sexo = $_POST['sexo'];
        $ddd = $_POST['ddd'];
        $tel = limpa($_POST['tel']);
        $mail = strtolower($_POST['email']);
        $sql = "INSERT INTO tb_clientes_pf (nome, cpf, telefone, dt_nasc, fk_ddd, sexo, email) VALUES (?,?,?,?,?,?,?);";

        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $nome);
        $stmt->bindValue(2, $cpf);
        $stmt->bindValue(3, $tel);
        $stmt->bindValue(4, $dtnasc);
        $stmt->bindValue(5, $ddd);
        $stmt->bindValue(6, $sexo);
        $stmt->bindValue(7, $mail);
        $stmt->execute();
        $id_end = $conex->lastInsertId();

        //Inserindo Endereco no banco de dados
        $cep = limpa($_POST['cep']);
        $logradouro = $_POST['logradouro'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $uf = $_POST['estado'];
        $compl = $_POST['compl'];
        $num = $_POST['numero'];

        $sql = "INSERT INTO tb_endereco (fk_cli_pf, logradouro, cidade, bairro, uf, numero, complemento, cep) VALUES (?,?,?,?,?,?,?,?);";
        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $id_end);
        $stmt->bindValue(2, $logradouro);
        $stmt->bindValue(3, $cidade);
        $stmt->bindValue(4, $bairro);
        $stmt->bindValue(5, $uf);
        $stmt->bindValue(6, $num);
        $stmt->bindValue(7, $compl);
        $stmt->bindValue(8, $cep);

        if ($stmt->execute()) {
            $_SESSION['recado'] = 'adicionado';
            header('Location: cadastro.php');
        } else {
            $_SESSION['recado'] = 'erroadicao';
            $_SESSION['nome_pf'] = $nome;
            $_SESSION['cpf'] = $cpf;
            $_SESSION['dtnasc'] = $dtnasc;
            $_SESSION['mail'] = $mail;
            $_SESSION['sexo'] = $sexo;
            $_SESSION['ddd'] = $ddd;
            $_SESSION['tel'] = $tel;
            $_SESSION['logradouro'] = $logradouro;
            $_SESSION['cidade'] = $cidade;
            $_SESSION['bairro'] = $bairro;
            $_SESSION['uf'] = $uf;
            $_SESSION['cep'] = $cep;
            $_SESSION['pessoa'] = $_POST['pessoa'];
            header('Location: cadastro.php');
        }
    } else {
        // pessoa juridica
        $empresa = ucwords(strtolower($_POST['empresa']));
        $cnpj = limpa($_POST['cnpj']);
        $resp = ucwords(strtolower($_POST['resp']));
        $ddd = $_POST['ddd_pj'];
        $tel = limpa($_POST['tel_pj']);
        $mail = strtolower($_POST['mail']);
        $rz = ucwords(strtolower($_POST['razao_soc']));

        $sql = "INSERT INTO tb_cliente_pj (empresa, email, razao_soc, cnpj, fk_ddd, telefone, responsavel) VALUES (?,?,?,?,?,?,?);";

        $stmt = $conex->prepare($sql);
        $stmt->bindValue(1, $empresa);
        $stmt->bindValue(2, $mail);
        $stmt->bindValue(3, $rz);
        $stmt->bindValue(4, $cnpj);
        $stmt->bindValue(5, $ddd);
        $stmt->bindValue(6, $tel);
        $stmt->bindValue(7, $resp);
        $stmt->execute();
        $id_end = $conex->lastInsertId();

        //Inserindo Endereco no banco de dados
        $cep = limpa($_POST['cep']);
        $logradouro = $_POST['logradouro'];
        $cidade = $_POST['cidade'];
        $bairro = $_POST['bairro'];
        $uf = $_POST['estado'];
        $compl = $_POST['compl'];
        $num = $_POST['numero'];
            $sql = "INSERT INTO tb_endereco (fk_cli_pj, logradouro, cidade, bairro, uf, numero, complemento, cep) VALUES (?,?,?,?,?,?,?,?);";
            $stmt = $conex->prepare($sql);
            $stmt->bindValue(1, $id_end);
            $stmt->bindValue(2, $logradouro);
            $stmt->bindValue(3, $cidade);
            $stmt->bindValue(4, $bairro);
            $stmt->bindValue(5, $uf);
            $stmt->bindValue(6, $num);
            $stmt->bindValue(7, $compl);
            $stmt->bindValue(8, $cep);

        if ($stmt->execute()) {
            $_SESSION['recado'] = 'adicionado';
            header('Location: cadastro.php');
        } else {
            $_SESSION['recado'] = 'erroadicao';
            $_SESSION['empresa'] = $empresa;
            $_SESSION['cnpj'] = $cnpj;
            $_SESSION['resp'] = $resp;
            $_SESSION['razao_soc'] = $rz;
            $_SESSION['ddd_pj'] = $ddd;
            $_SESSION['tel_pj'] = $tel;
            $_SESSION['mail_pj'] = $mail;
            $_SESSION['logradouro'] = $logradouro;
            $_SESSION['cidade'] = $cidade;
            $_SESSION['bairro'] = $bairro;
            $_SESSION['uf'] = $uf;
            $_SESSION['cep'] = $cep;
            $_SESSION['pessoa'] = $_POST['pessoa'];
            header('Location: cadastro.php');
        }
    }
} else {
    header('Location: login.php');
}