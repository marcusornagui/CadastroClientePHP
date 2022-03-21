window.onload = function () {
    carregarEstado();
    carregar();
};

var oCliente = new Object();
var vEndereco = new Array();
var vEstado = new Array();

function carregar() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var id = url.searchParams.get("id");

    if (id === '' || id === null) {
        return;
    }

    var http = new XMLHttpRequest();
    var url = 'service/clientecadastroservice.php?id=' + id;

    http.open('GET', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let oClienteResponse = http.responseText;
            oClienteResponse = JSON.parse(this.responseText);
            console.log(oClienteResponse);

            oCliente = oClienteResponse;

            exibirCliente();

        } else if (http.status == 500) {
            let oCliente = http.responseText;
            oCliente = JSON.parse(this.responseText);
            console.log(oCliente);
        }
    }
    http.send();
}

function exibirCliente() {
    if (oCliente.length > 0) {
        return;
    }

    document.getElementById("id").value = oCliente.id;
    document.getElementById("nome").value = oCliente.nome;
    document.getElementById("cpf").value = oCliente.cpf;
    document.getElementById("rg").value = oCliente.rg;
    document.getElementById("telefone").value = oCliente.telefone;
    document.getElementById("datanascimento").value = oCliente.dataNascimento;

    vEndereco = oCliente.clienteEndereco;

    exibirEndereco();
}

function exibirEndereco() {
    if (vEndereco.length > 0) {
        var htmlEnderecos = "<h4>ENDEREÇOS</h4>";
        htmlEnderecos = "<table>";
        htmlEnderecos += "<tr>";
        htmlEnderecos += "<th>CEP</th>";
        htmlEnderecos += "<th>LOGRADOURO</th>";
        htmlEnderecos += "<th>NÚMERO</th>";
        htmlEnderecos += "<th>COMPLEMENTO</th>";
        htmlEnderecos += "<th>BAIRRO</th>";
        htmlEnderecos += "<th>CIDADE</th>";
        htmlEnderecos += "<th>UF</th>";
        htmlEnderecos += "<th></th>";
        htmlEnderecos += "</tr>";

        for (var endereco in vEndereco) {
            htmlEnderecos += "<tr>";
            htmlEnderecos += "<td>" + vEndereco[endereco].cep + "</td>";
            htmlEnderecos += "<td>" + vEndereco[endereco].logradouro + "</td>";
            htmlEnderecos += "<td>" + vEndereco[endereco].numero + "</td>";
            htmlEnderecos += "<td>" + vEndereco[endereco].complemento + "</td>";
            htmlEnderecos += "<td>" + vEndereco[endereco].bairro + "</td>";
            htmlEnderecos += "<td>" + vEndereco[endereco].cidade + "</td>";

            for (var estado in vEstado) {
                if (parseInt(vEstado[estado].id) === parseInt(vEndereco[endereco].idEstado)) {
                    htmlEnderecos += "<td>" + vEstado[estado].sigla + "</td>";
                    break;
                }
            }

            htmlEnderecos += "<td><button id='button-excluir' onclick='excluirEndereco(" + endereco + ")'>Excluir</button></td>";
            htmlEnderecos += "</tr>";
        }

        htmlEnderecos += "</table>"

        document.getElementById("enderecos").innerHTML = htmlEnderecos;
    } else {
        document.getElementById("enderecos").innerHTML = "Nenhum endereço cadastrado!";
    }
}

function excluirEndereco(pId) {
    console.log(pId);

    vEndereco.splice(pId, 1);

    exibirEndereco();
}

function incluirEndereco() {
    var oEndereco = new Object();

    oEndereco.cep = document.getElementById("cep").value;
    oEndereco.logradouro = document.getElementById("logradouro").value;
    oEndereco.numero = document.getElementById("numero").value;
    oEndereco.complemento = document.getElementById("complemento").value;
    oEndereco.bairro = document.getElementById("bairro").value;
    oEndereco.cidade = document.getElementById("cidade").value;
    oEndereco.idEstado = document.getElementById("uf").value;

    if (oEndereco.cep === '' || oEndereco.logradouro === '' || oEndereco.numero === ''
            || oEndereco.bairro === '' || oEndereco.cidade === '' || oEndereco.idEstado === '') {
        document.getElementById("mensagem-endereco").innerHTML = 'Por favor, preencha todos os campos!';
        return;
    }

    vEndereco.push(oEndereco);

    document.getElementById("cep").value = '';
    document.getElementById("logradouro").value = '';
    document.getElementById("numero").value = '';
    document.getElementById("complemento").value = '';
    document.getElementById("bairro").value = '';
    document.getElementById("cidade").value = '';

    exibirEndereco();
}

function salvar() {
    console.log(vEndereco);

    var oParametro = new Object();
    oParametro.id = parseInt(document.getElementById("id").value);
    oParametro.nome = document.getElementById("nome").value;
    oParametro.cpf = document.getElementById("cpf").value;
    oParametro.rg = document.getElementById("rg").value;
    oParametro.telefone = document.getElementById("telefone").value;
    oParametro.datanascimento = document.getElementById("datanascimento").value;
    oParametro.vEndereco = vEndereco;

    if (oParametro.nome === '' || oParametro.cpf === '' || oParametro.rg === ''
            || oParametro.telefone === '' || oParametro.datanascimento === '') {
        document.getElementById("mensagem-dados").innerHTML = 'Por favor, preencha todos os campos!';
        return;
    } else if (oParametro.vEndereco.length === 0) {
        document.getElementById("enderecos").innerHTML = 'Por favor, informar ao menos um endereço!';
        return;
    }


    var http = new XMLHttpRequest();
    var url = 'service/clientecadastroservice.php';
    var params = JSON.stringify(oParametro);

    console.log(params);

    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);
            console.log(resposta);

            window.location.href = 'clienteconsulta';

        } else if (http.status == 500) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);
            console.log(resposta);
        }
    }
    http.send(params);
}


function carregarEstado() {
    var url_string = window.location.href;
    var url = new URL(url_string);
    var http = new XMLHttpRequest();
    var url = 'service/estadoservice.php';

    http.open('GET', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let estadoResponse = http.responseText;
            estadoResponse = JSON.parse(this.responseText);
            console.log(estadoResponse);

            vEstado = estadoResponse;

            exibirEstado();

        } else if (http.status == 500) {
            let oCliente = http.responseText;
            oCliente = JSON.parse(this.responseText);
            console.log(oCliente);
        }
    }
    http.send();
}

function exibirEstado() {
    if (vEstado.length === 0) {
        return;
    }

    var htmlEstados = "<select name='uf' id='uf'>"

    for (var estado in vEstado) {
        htmlEstados += "<option value='" + vEstado[estado].id + "'>" + vEstado[estado].sigla + "</option>";
    }

    htmlEstados += "</select>"

    document.getElementById("estados").innerHTML = htmlEstados;
}



