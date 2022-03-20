<?php
require_once './Sessao.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes - Cadastro</title>
    </head>
    <body>
        <label>ID:</label><input type="text" name="id" id="id" disabled="disabled"><br>
        <label>NOME:</label><input type="text" name="nome" id="nome"><br>
        <label>CPF:</label><input type="text" name="cpf" id="cpf"><br>
        <label>RG:</label><input type="text" name="rg" id="rg"><br>
        <label>TELEFONE:</label><input type="text" name="telefone" id="telefone"><br>
        <label>DATA NASCIMENTO:</label><input type="text" name="datanascimento" id="datanascimento"><br>
        <button onclick="salvar()">Salvar</button>
    </body>

    <script>
        window.onload = function () {
            carregar();
        };

        function salvar() {
            var id = document.getElementById("id").value;
            var nome = document.getElementById("nome").value;
            var cpf = document.getElementById("cpf").value;
            var rg = document.getElementById("rg").value;
            var telefone = document.getElementById("telefone").value;
            var datanascimento = document.getElementById("datanascimento").value;
            var http = new XMLHttpRequest();
            var url = 'service/ClienteCadastroService.php';
            var params = 'id=' + id
                    + '&nome=' + nome
                    + '&cpf=' + cpf
                    + '&rg=' + rg
                    + '&telefone=' + telefone
                    + '&datanascimento=' + datanascimento;

            http.open('POST', url, true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);
                } else if (http.status == 500) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);
                }
            }
            http.send(params);
        }

        function carregar() {
            var url_string = window.location.href;
            var url = new URL(url_string);
            var id = url.searchParams.get("id");

            if (id === '' || id === null) {
                return;
            }

            var http = new XMLHttpRequest();
            var url = 'service/ClienteCadastroService.php?id=' + id;

            http.open('GET', url, true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);

                    if (resposta.length === 0) {
                        return;
                    }

                    document.getElementById("id").value = resposta.id;
                    document.getElementById("nome").value = resposta.nome;
                    document.getElementById("cpf").value = resposta.cpf;
                    document.getElementById("rg").value = resposta.rg;
                    document.getElementById("telefone").value = resposta.telefone;
                    document.getElementById("datanascimento").value = formatarData(resposta.datanascimento);

                } else if (http.status == 500) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);
                }
            }
            http.send();
        }

        function formatarData(pData) {
            data = new Date(pData);
            dataFormatada = data.toLocaleDateString('pt-BR', {timeZone: 'UTC'});
            return dataFormatada;
        }
    </script>

</html>
