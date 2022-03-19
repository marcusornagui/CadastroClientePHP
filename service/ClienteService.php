<?php

require_once('../model/ClienteVO.php');
require_once('../repository/ClienteDAO.php');

$resposta = array();

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    try {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $rg = $_POST['rg'];
        $telefone = $_POST['telefone'];
        $dataNascimento = $_POST['datanascimento'];

        $cliente = new ClienteVO();
        $cliente->setNome($nome);
        $cliente->setCpf($cpf);
        $cliente->setRg($rg);
        $cliente->setTelefone($telefone);
        $cliente->setDataNascimento($dataNascimento);

        $instance = new ClienteDAO();
        $instance->inserir($cliente);

        $resposta["status"] = "OK";
        $resposta["mensagem"] = "Cadastro realizado com sucesso.";
        
    } catch (Exception $e) {
        http_response_code(500);
        $resposta["status"] = "ERROR";
        $resposta["mensagem"] = $e->getMessage();
    }
}


echo json_encode($resposta);

