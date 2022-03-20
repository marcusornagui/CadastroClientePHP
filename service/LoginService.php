<?php

session_start();

require_once('../repository/UsuarioDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $resposta = array();

    try {
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $instance = new UsuarioDAO();

        $id = $instance->autenticar($login, $senha);

        if ($id > 0) {
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $login;
            $resposta["status"] = "OK";
            $resposta["mensagem"] = "Usuário autenticado com sucesso.";
        } else {
            session_destroy();
            $resposta["status"] = "ERRO";
            $resposta["mensagem"] = "Usuário ou senha inválido.";
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


