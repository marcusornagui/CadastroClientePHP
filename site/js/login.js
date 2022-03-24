function login() {
    var login = document.getElementById("login").value;
    var senha = document.getElementById("senha").value;
    var http = new XMLHttpRequest();
    var url = '../webservice/service/LoginService.php';
    var params = 'login=' + login
            + '&senha=' + senha;

    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);

            if (resposta.status === 'OK') {
                window.location.replace('index.php');

            } else if (resposta.status === 'ERRO') {
                document.getElementById("mensagem-login").innerHTML = resposta.mensagem;
            }

        } else if (http.status == 500) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);
            console.log(resposta);
        }
    }
    http.send(params);
}
