window.onload = function () {
    consultar();
};

function consultar() {
    var http = new XMLHttpRequest();
    var url = 'service/ClienteConsultaService.php';

    http.open('GET', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let vCliente = http.responseText;
            vCliente = JSON.parse(this.responseText);

            var htmlClientes = "<table>";
            htmlClientes += "<tr>";
            htmlClientes += "<th>ID</th>";
            htmlClientes += "<th>NOME</th>";
            htmlClientes += "<th>DATA NASCIMENTO</th>";
            htmlClientes += "<th>CPF</th>";
            htmlClientes += "<th>RG</th>";
            htmlClientes += "<th>TELEFONE</th>";
            htmlClientes += "<th></th>";
            htmlClientes += "<th></th>";
            htmlClientes += "</tr>";

            for (var cliente in vCliente) {
                htmlClientes += "<tr>";
                htmlClientes += "<td>" + vCliente[cliente].id + "</td>";
                htmlClientes += "<td>" + vCliente[cliente].nome + "</td>";
                htmlClientes += "<td>" + formatarData(vCliente[cliente].datanascimento) + "</td>";
                htmlClientes += "<td>" + vCliente[cliente].cpf + "</td>";
                htmlClientes += "<td>" + vCliente[cliente].rg + "</td>";
                htmlClientes += "<td>" + vCliente[cliente].telefone + "</td>";
                htmlClientes += "<td><button id='button-editar' onclick='editar(" + vCliente[cliente].id + ")'>Editar</button></td>";
                htmlClientes += "<td><button id='button-excluir' onclick='excluir(" + vCliente[cliente].id + ")'>Excluir</button></td>";
                htmlClientes += "</tr>";
            }

            htmlClientes += "</table>"

            document.getElementById("clientes").innerHTML = htmlClientes;


        } else if (http.status == 500) {
            let vCliente = http.responseText;
            vCliente = JSON.parse(this.responseText);
            console.log(vCliente);
        }
    }
    http.send();
}

function editar(pId) {
    window.location.href='clientecadastro?id=' + pId;
}

function excluir(pId) {
    var http = new XMLHttpRequest();
    var url = 'service/ClienteConsultaService.php?id=' + pId;

    http.open('DELETE', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);
            console.log(resposta);

            consultar();

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