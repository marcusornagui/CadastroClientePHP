<?php
require_once '../Sessao.php';
require_once('../repository/ClienteDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    $instance = new ClienteDAO();

    echo json_encode($instance->consultar());
} else if ($_SERVER["REQUEST_METHOD"] == 'DELETE') {
    $resposta = array();

    try {
        $id = $_GET['id'];

        $instance = new ClienteDAO();

        $instance->excluir($id);

        $resposta["status"] = "OK";
        $resposta["mensagem"] = "Cadastro excluído com sucesso.";
    } catch (Exception $e) {
        http_response_code(500);
        $resposta["status"] = "ERROR";
        $resposta["mensagem"] = $e->getMessage();
    }

    echo json_encode($resposta);
}


