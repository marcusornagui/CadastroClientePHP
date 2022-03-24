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
    var url = '../webservice/service/clientecadastroservice.php?id=' + id;

    http.open('GET', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let oClienteResponse = http.responseText;
            oClienteResponse = JSON.parse(this.responseText);

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
    document.getElementById("cpf").value = formatarCPF(oCliente.cpf);
    document.getElementById("rg").value = formatarRG(oCliente.rg);
    document.getElementById("telefone").value = formatarTelefone(oCliente.telefone.toLocaleString());
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
            htmlEnderecos += "<td>" + formatarCep(vEndereco[endereco].cep) + "</td>";
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
    vEndereco.splice(pId, 1);

    exibirEndereco();
}

function incluirEndereco() {
    var oEndereco = new Object();

    oEndereco.cep = document.getElementById("cep").value.replace(/[^0-9]/g, '');
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
    var oParametro = new Object();
    oParametro.id = parseInt(document.getElementById("id").value);
    oParametro.nome = document.getElementById("nome").value;
    oParametro.cpf = document.getElementById("cpf").value.replace(/[^0-9]/g, '');
    oParametro.rg = document.getElementById("rg").value.replace(/[^0-9]/g, '');
    oParametro.telefone = document.getElementById("telefone").value.replace(/[^0-9]/g, '');
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
    var url = '../webservice/service/clientecadastroservice.php';
    var params = JSON.stringify(oParametro);
    
    http.open('POST', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let resposta = http.responseText;
            resposta = JSON.parse(this.responseText);

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
    var url = '../webservice/service/estadoservice.php';

    http.open('GET', url, true);
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    http.onreadystatechange = function () {
        if (http.readyState == 4 && http.status == 200) {
            let estadoResponse = http.responseText;
            estadoResponse = JSON.parse(this.responseText);

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

function mascara(o, tipo) {
    setTimeout(function () {
        if (tipo === 'telefone') {
            var telefone = formatarTelefone(o.value);
            if (telefone != o.value) {
                o.value = telefone;
            }

        } else if (tipo === 'cpf') {
            var cpf = formatarCPF(o.value);
            if (cpf != o.value) {
                o.value = cpf;
            }
        } else if (tipo === 'rg') {
            var rg = formatarRG(o.value);
            if (rg != o.value) {
                o.value = rg;
            }
            
        }  else if (tipo === 'cep') {
            var cep = formatarCep(o.value);
            if (cep != o.value) {
                o.value = cep;
            }
        }

    }, 1);
}

function formatarTelefone(telefone) {
    var r = telefone.replace(/\D/g, "");
    r = r.replace(/^0/, "");

    if (r.length > 10) {
        r = r.replace(/^(\d\d)(\d{5})(\d{4}).*/, "($1) $2-$3");
    } else if (r.length > 5) {
        r = r.replace(/^(\d\d)(\d{4})(\d{0,4}).*/, "($1) $2-$3");
    } else if (r.length > 2) {
        r = r.replace(/^(\d\d)(\d{0,5})/, "($1) $2");
    } else {
        r = r.replace(/^(\d*)/, "($1");
    }
    return r;
}


function formatarCPF(cpf) {
    cpf = cpf.toString().replace(/[^\d]/g, "");

    if (cpf.length > 10) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2}).*/, "\$1.\$2.\$3-\$4");
    } else if (cpf.length > 8) {
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})/, "\$1.\$2.\$3-");
    } else if (cpf.length > 5) {
        cpf = cpf.replace(/(\d{3})(\d{3})/, "\$1.\$2.");
    } else if (cpf.length > 2) {
        cpf = cpf.replace(/(\d{3})/, "\$1.");
    }

    return cpf;
}

function formatarRG(rg) {
    rg = rg.toString().replace(/\D/g, "");

    if (rg.length > 8) {
        rg = rg.replace(/(\d{2})(\d{3})(\d{3})(\d{1}).*/, "$1.$2.$3-$4");
    } else if (rg.length > 7) {
        rg = rg.replace(/(\d{2})(\d{3})(\d{3})/, "$1.$2.$3-");
    } else if (rg.length > 4) {
        rg = rg.replace(/(\d{2})(\d{3})/, "$1.$2.");
    } else if (rg.length > 1) {
        rg = rg.replace(/(\d{2})/, "$1.");
    }
    
    return rg;
}

function formatarCep(cep) {
    cep = cep.toString().replace(/\D/g, "");

    if (cep.length > 7) {
        cep = cep.replace(/(\d{2})(\d{3})(\d{3}).*/, "$1.$2-$3");
    } else if (cep.length > 4) {
        cep = cep.replace(/(\d{2})(\d{3})/, "$1.$2-");
    }  else if (cep.length > 1) {
        cep = cep.replace(/(\d{2})/, "$1.");
    }
    
    return cep;
}



