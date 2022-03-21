<?php
require_once './Sessao.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/menu.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <?php require_once './NavBar.php'; ?>
        
        <form method="get" action="clienteconsulta.php">
            <button id="button-cliente" type="submit">Cadastro Cliente</button>
        </form>

    </body>



</html>
