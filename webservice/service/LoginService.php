<?php

session_start();

require_once('../repository/UsuarioDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $resposta = array();

    try {
        $login = $_POST['login'];
        $senha = md5($_POST['senha']);

        $instance = new UsuarioDAO();

        $usuario = $instance->autenticar($login, $senha);

        if ($usuario->getId() > 0) {
            $_SESSION['id'] = $usuario->getId();
            $_SESSION['login'] = $usuario->getLogin();
            $_SESSION['nome'] = $usuario->getNome();
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
}


