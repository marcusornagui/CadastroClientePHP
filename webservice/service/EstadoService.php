<?php
require_once('../Sessao.php');
require_once('../repository/EstadoDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    $estadoDAO = new EstadoDAO();

    echo json_encode($estadoDAO->consultar());
}

