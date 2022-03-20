<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes - Login</title>
    </head>
    <body>
        <label>USUÁRIO:</label><input type="text" name="login" id="login"><br>
        <label>SENHA:</label><input type="password" name="senha" id="senha"><br>
        <button onclick="login()">Login</button>
    </body>

    <script>
        function login() {
            var login = document.getElementById("login").value;
            var senha = document.getElementById("senha").value;
            var http = new XMLHttpRequest();
            var url = 'service/LoginService.php';
            var params = 'login=' + login
                    + '&senha=' + senha;

            http.open('POST', url, true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);
                    
                    window.location.replace('index.php');
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
