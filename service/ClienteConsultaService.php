<?php

require_once('../Sessao.php');
require_once('../repository/ClienteDAO.php');
require_once('../repository/ClienteEnderecoDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    $clienteDAO = new ClienteDAO();

    echo json_encode($clienteDAO->consultar());
} else if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    $resposta = array();

    try {
        $id = $_GET['id'];

        $clienteEnderecoDAO = new ClienteEnderecoDAO();
        $clienteEnderecoDAO->excluir($id);

        $clienteDAO = new ClienteDAO();
        $clienteDAO->excluir($id);

        $resposta["status"] = "OK";
        $resposta["mensagem"] = "Cadastro excluído com sucesso.";
    } catch (Exception $e) {
        http_response_code(500);
        $resposta["status"] = "ERROR";
        $resposta["mensagem"] = $e->getMessage();
    }

    echo json_encode($resposta);
}


