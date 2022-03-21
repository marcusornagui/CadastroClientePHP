<?php
require_once './Sessao.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes - Consulta</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/clienteconsulta.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/clienteconsulta.js"></script>
    </head>
    <body>
        <?php require_once './NavBar.php'; ?>

        <button id="button-incluir" onclick="location.href = 'clientecadastro'">Incluir</button>
        <button id="button-consultar" onclick="consultar()">Consultar</button>

        <div id="clientes"></div>
    </body>
</html>
