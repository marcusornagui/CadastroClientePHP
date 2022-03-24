<?php
require_once './Sessao.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes - Cadastro</title>
        <link href="css/style.css" rel="stylesheet" type="text/css">
        <link href="css/clientecadastro.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="js/clientecadastro.js"></script>
    </head>
    <body>
        <?php require_once './NavBar.php'; ?>

        <div id="dados">
            <div id="dados-basicos">
                <h4>DADOS BÁSICOS </h4>
                <div class="label-basico"><label>ID</label></div>
                <div class="input-basico"><input type="text" name="id" id="id" disabled="disabled"></div>
                <div class="label-basico"><label>NOME</label></div>
                <div class="input-basico"><input type="text" name="nome" id="nome" maxlength="50"></div>
                <div class="label-basico"><label>CPF</label></div>
                <div class="input-basico"><input type="text" name="cpf" id="cpf" onkeypress="mascara(this, 'cpf');"></div>
                <div class="label-basico"><label>RG</label></div>
                <div class="input-basico"><input type="text" name="rg" id="rg" onkeypress="mascara(this, 'rg');"></div>
                <div class="label-basico"><label>TELEFONE</label></div>
                <div class="input-basico"><input type="tel" name="telefone" id="telefone" onkeypress="mascara(this, 'telefone');"></div>
                <div class="label-basico"><label>DATA NASCIMENTO</label></div>
                <div class="input-basico"><input type="date" name="datanascimento" id="datanascimento"></div>

                <div id="mensagem-dados"></div>
            </div>



            <div id="endereco"> 
                <h4>NOVO ENDEREÇO</h4>

                <div id="cadastro-endereco">
                    <div class="label-endereco"><label>CEP</label></div>
                    <div class="input-endereco"><input type="text" name="cep" id="cep" onkeypress="mascara(this, 'cep');"></div>
                    <div class="label-endereco"><label>LOGRADOURO</label></div>
                    <div class="input-endereco"><input type="text" name="logradouro" id="logradouro" maxlength="100"></div>
                    <div class="label-endereco"><label>NÚMERO</label></div>
                    <div class="input-endereco"><input type="text" name="numero" id="numero" maxlength="10"></div>
                    <div class="label-endereco"><label>COMPLEMENTO</label></div>
                    <div class="input-endereco"><input type="text" name="complemento" id="complemento" maxlength="80"></div>
                    <div class="label-endereco"><label>BAIRRO</label></div>
                    <div class="input-endereco"><input type="text" name="bairro" id="bairro" maxlength="50"></div>
                    <div class="label-endereco"><label>CIDADE</label></div>
                    <div class="input-endereco"><input type="text" name="cidade" id="cidade" maxlength="50"></div>
                    <div class="label-endereco"><label>UF</label></div>
                    <div class="input-endereco"><div id="estados"></div></div>
                    <div id="mensagem-endereco"></div>
                    <button id="button-incluir-endereco" onclick="incluirEndereco()">Incluir Endereço</button>
                </div>


            </div>
        </div>


    </div>


    <div id="endereco-lista"> 
        <h4>ENDEREÇOS CADASTRADOS</h4>
        <div id="enderecos">Nenhum endereço cadastrado!</div>
    </div>


    <button id="button-salvar" onclick="salvar()">Salvar</button>

    <form method="get" action="clienteconsulta.php">
        <button id="button-cancelar" type="submit">Cancelar</button>
    </form>




</body>
</html>
