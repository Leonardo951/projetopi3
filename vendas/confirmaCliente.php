<?php
require_once '../conexao.php';

$campo = $_GET['campo'];
$tipo = $_GET['tipo'];
//Se for cliente pessoa física
if($tipo == 'PF'){
    $sql = 'SELECT nome FROM tb_clientes_pf WHERE nome = :nome OR cpf = :cpf;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('nome', $campo);
    $stmt->bindParam('cpf', $campo);
    $stmt->execute();
    $resultado = $stmt->fetch();
//    Se não existir cliente com os dados informados retorna true
    if(empty($resultado)){
        echo json_encode(array(
            "result" => true
        ));
    }else {
        echo json_encode(array(
            "result" => false
        ));
    }
//    Se o liente for pessoa jurídica
}else{
    $resp = $_GET['resp'];
    $sql = 'SELECT empresa FROM tb_cliente_pj WHERE (empresa = :empresa OR cnpj = :cnpj) AND responsavel = :responsavel;';
    $stmt = $conex->prepare($sql);
    $stmt->bindParam('empresa', $campo);
    $stmt->bindParam('cnpj', $campo);
    $stmt->bindParam('responsavel', $resp);
    $stmt->execute();
    $resultado = $stmt->fetch();
//    Se o resultado for que há um erro, verificar qual campo foi informado incorretamente
    if(empty($resultado)){
        $sql = 'SELECT empresa FROM tb_cliente_pj WHERE empresa = :empresa OR cnpj = :cnpj;';
        $stmt = $conex->prepare($sql);
        $stmt->bindParam('empresa', $campo);
        $stmt->bindParam('cnpj', $campo);
        $stmt->execute();
        $res = $stmt->fetch();
        if(empty($res)){
//        O campo errado é o do nome da empresa, ou seja, considerar os 2 como errados
            echo json_encode(array(
                "result" => true,
                "onde" => 'buscaPJ'
            ));
        }else{
//            O campo errado e o do responsável
            echo json_encode(array(
                "result" => true,
                "onde" => 'buscaResp'
            ));
        }
//        Retorna falso caso os campos forem informados corretamente
    }else {
        echo json_encode(array(
            "result" => false
        ));
    }
}