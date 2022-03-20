<?php

require_once('../model/ClienteVO.php');
require_once('../repository/ClienteDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'GET') {

    $instance = new ClienteDAO();

    echo json_encode($instance->consultar());
}


