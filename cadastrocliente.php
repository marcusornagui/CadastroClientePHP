<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes</title>
    </head>
    <body>
        <label>NOME:</label><input type="text" name="nome" id="nome"><br>
        <label>CPF:</label><input type="text" name="cpf" id="cpf"><br>
        <label>RG:</label><input type="text" name="rg" id="rg"><br>
        <label>TELEFONE:</label><input type="text" name="telefone" id="telefone"><br>
        <label>DATA NASCIMENTO:</label><input type="text" name="datanascimento" id="datanascimento"><br>
        <button onclick="salvar()">Salvar</button>
    </body>

    <script>
        function salvar() {
            var id = 10;
            var nome = document.getElementById("nome").value;
            var cpf = document.getElementById("cpf").value;
            var rg = document.getElementById("rg").value;
            var telefone = document.getElementById("telefone").value;
            var datanascimento = document.getElementById("datanascimento").value;
            var http = new XMLHttpRequest();
            var url = 'service/ClienteService.php';
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
    </script>

</html>
