window.onload = function () {
    consultar();
};

function consultar() {
    var http = new XMLHttpRequest();
    var url = '../webservice/service/ClienteConsultaService.php';

    http.open('GET', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let vCliente = http.responseText;
            vCliente = JSON.parse(this.responseText);

            var htmlClientes = "";

            if (vCliente.length > 0) {
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
                    htmlClientes += "<td>" + formatarCPF(vCliente[cliente].cpf) + "</td>";
                    htmlClientes += "<td>" + formatarRG(vCliente[cliente].rg) + "</td>";
                    htmlClientes += "<td>" + formatarTelefone(vCliente[cliente].telefone) + "</td>";
                    htmlClientes += "<td><button id='button-editar' onclick='editar(" + vCliente[cliente].id + ")'>Editar</button></td>";
                    htmlClientes += "<td><button id='button-excluir' onclick='excluir(" + vCliente[cliente].id + ")'>Excluir</button></td>";
                    htmlClientes += "</tr>";
                }

                htmlClientes += "</table>"

            } else {
                htmlClientes = "Nenhum cliente cadastrado!";
            }

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
    window.location.href = 'clientecadastro?id=' + pId;
}

function excluir(pId) {
    var http = new XMLHttpRequest();
    var url = '../webservice/service/ClienteConsultaService.php?id=' + pId;

    http.open('DELETE', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);

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

function formatarCPF(cpf) {
    cpf = cpf.toString().replace(/[^\d]/g, "");
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3-\$4");
}

function formatarRG(rg) {
    rg = rg.toString().replace(/\D/g, "");
    rg = rg.replace(/(\d{2})(\d{3})(\d{3})(\d{1})$/, "$1.$2.$3-$4");
    return rg;
}

function formatarTelefone(rg) {
    var r = rg.toString().replace(/\D/g, "");
    r = r.replace(/^0/, "");
    if (r.length > 10) {
        r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (r.length > 9) {
        r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    }
    return r;
}