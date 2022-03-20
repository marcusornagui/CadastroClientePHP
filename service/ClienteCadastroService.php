<?php
require_once '../Sessao.php';
require_once('../model/ClienteVO.php');
require_once('../repository/ClienteDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $resposta = array();
    
    try {
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $rg = $_POST['rg'];
        $telefone = $_POST['telefone'];
        $dataNascimento = $_POST['datanascimento'];

        $cliente = new ClienteVO();
        $cliente->setId($id);
        $cliente->setNome($nome);
        $cliente->setCpf($cpf);
        $cliente->setRg($rg);
        $cliente->setTelefone($telefone);
        $cliente->setDataNascimento($dataNascimento);

        $instance = new ClienteDAO();

        if ($id > 0 && $instance->idExiste($cliente->getId())) {
            $instance->alterar($cliente);

            $resposta["status"] = "OK";
            $resposta["mensagem"] = "Cadastro alterado com sucesso.";
        } else {
            $instance->inserir($cliente);

            $resposta["status"] = "OK";
            $resposta["mensagem"] = "Cadastro realizado com sucesso.";
        }
    } catch (Exception $e) {
        http_response_code(500);
        $resposta["status"] = "ERROR";
        $resposta["mensagem"] = $e->getMessage();
    }

    echo json_encode($resposta);
} else if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    
    $instance = new ClienteDAO();

    echo json_encode($instance->carregar($id));
}


