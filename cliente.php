<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastro de Clientes - Consulta</title>
    </head>
    <body>
        <button onclick="consultar()">Consultar</button>
        <div id="clientes"></div>


    </body>

    <script>
        function consultar() {
            var http = new XMLHttpRequest();
            var url = 'service/ClienteConsultaService.php';
            var params = '';


            http.open('GET', url, true);
            http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            http.onreadystatechange = function () {
                if (http.readyState == 4 && http.status == 200) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);


                    var htmlClientes = "<table>";

                    for (var j = 0; j < resposta.length; j++) {
                        htmlClientes += "<tr>";
                        htmlClientes += "<td>" + resposta[j].nome + "</td>";
                        htmlClientes += "<td>" + formatarData(resposta[j].datanascimento) + "</td>";
                        htmlClientes += "<td>" + resposta[j].cpf + "</td>";
                        htmlClientes += "<td>" + resposta[j].rg + "</td>";
                        htmlClientes += "<td>" + resposta[j].telefone + "</td>";
                        htmlClientes += "</tr>";
                    }

                    htmlClientes += "</table>"

                    document.getElementById("clientes").innerHTML = htmlClientes;


                } else if (http.status == 500) {
                    let resposta = http.responseText;
                    resposta = JSON.parse(this.responseText);
                    console.log(resposta);
                }
            }
            http.send(params);
        }

        function formatarData(pData) {
            data = new Date(pData);
            dataFormatada = data.toLocaleDateString('pt-BR', {timeZone: 'UTC'});
            return dataFormatada;
        }
    </script>

</html>
