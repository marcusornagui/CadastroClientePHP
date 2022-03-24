<?php

require_once('../Sessao.php');
require_once('../model/ClienteVO.php');
require_once('../model/ClienteEnderecoVO.php');
require_once('../repository/ClienteDAO.php');
require_once('../repository/ClienteEnderecoDAO.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $resposta = array();

    try {
        $str_json = file_get_contents('php://input');

        $cliente_json = json_decode($str_json);

        $cliente = new ClienteVO();
        $cliente->setId($cliente_json->{'id'});
        $cliente->setNome($cliente_json->{'nome'});
        $cliente->setCpf($cliente_json->{'cpf'});
        $cliente->setRg($cliente_json->{'rg'});
        $cliente->setTelefone($cliente_json->{'telefone'});
        $cliente->setDataNascimento($cliente_json->{'datanascimento'});

        $clienteEndereco = array();

        foreach ($cliente_json->{'vEndereco'} as $endereco_json) {
            $endereco = new ClienteEnderecoVO();
            $endereco->setCep($endereco_json->{'cep'});
            $endereco->setLogradouro($endereco_json->{'logradouro'});
            $endereco->setNumero($endereco_json->{'numero'});
            $endereco->setComplemento($endereco_json->{'complemento'});
            $endereco->setBairro($endereco_json->{'bairro'});
            $endereco->setCidade($endereco_json->{'cidade'});
            $endereco->setIdEstado($endereco_json->{'idEstado'});

            array_push($clienteEndereco, $endereco);
        }

        $cliente->setClienteEndereco($clienteEndereco);

        $clienteDAO = new ClienteDAO();
        $clienteEnderecoDAO = new ClienteEnderecoDAO();

        if ($cliente->getId() > 0 && $clienteDAO->idExiste($cliente->getId())) {
            $clienteDAO->alterar($cliente);

            $clienteEnderecoDAO->excluir($cliente->getId());

            foreach ($cliente->getClienteEndereco() as $endereco) {
                $endereco->setIdCliente($cliente->getId());

                $clienteEnderecoDAO->inserir($endereco);
            }

            $resposta["status"] = "OK";
            $resposta["mensagem"] = "Cadastro alterado com sucesso.";
        } else {
            $idCliente = $clienteDAO->inserir($cliente);

            foreach ($cliente->getClienteEndereco() as $endereco) {
                $endereco->setIdCliente($idCliente);

                $clienteEnderecoDAO->inserir($endereco);
            }

            $resposta["status"] = "OK";
            $resposta["mensagem"] = "Cadastro realizado com sucesso.";
        }
    } catch (Exception $e) {
        http_response_code(500);
        $resposta["status"] = "ERROR";
        $resposta["mensagem"] = $e->getMessage();
    }

    echo json_encode($resposta);
} else if ($_SERVER["REQUEST_METHOD"] == 'GET') {
    $id = isset($_GET['id']) ? $_GET['id'] : 0;

    $clienteDAO = new ClienteDAO();
    $cliente = $clienteDAO->carregar($id);

    $clienteEnderecoDAO = new ClienteEnderecoDAO();
    $clienteEndereco = $clienteEnderecoDAO->carregar($cliente->getId());

    $cliente->setClienteEndereco($clienteEndereco);

    echo json_encode($cliente);
}


