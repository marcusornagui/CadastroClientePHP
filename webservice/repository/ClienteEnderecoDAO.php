<?php
require_once('../Sessao.php');
require_once('../model/ClienteVO.php');
require_once('../model/ClienteEnderecoVO.php');
require_once('../repository/Conexao.php');

class ClienteEnderecoDAO {

    public static $instance;

    public function __construct() {
        
    }

    public function carregar($idCliente) {
        try {
            $sql = "SELECT id, id_cliente, cep, logradouro, numero, bairro, cidade, complemento, id_estado";
            $sql .= " FROM enderecocliente";
            $sql .= " WHERE id_cliente = :idCliente";

            $p_sql = Conexao::getConnection()->prepare($sql);
            $p_sql->bindValue(":idCliente", $idCliente);
            $p_sql->execute();

            $clienteEndereco = array();

            while ($result = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $endereco = new ClienteEnderecoVO();
                $endereco->setId($result['id']);
                $endereco->setIdCliente($result['id_cliente']);
                $endereco->setCep($result['cep']);
                $endereco->setLogradouro($result['logradouro']);
                $endereco->setNumero($result['numero']);
                $endereco->setBairro($result['bairro']);
                $endereco->setCidade($result['cidade']);
                $endereco->setComplemento($result['complemento']);
                $endereco->setIdEstado($result['id_estado']);

                array_push($clienteEndereco, $endereco);
            }

            return $clienteEndereco;
        } catch (Exception $e) {
            throw new Exception("Erro ao carregar cliente: " . $e->getMessage());
        }
    }

    public function inserir(ClienteEnderecoVO $clienteEndereco) {
        try {
            $sql = "INSERT INTO enderecocliente (";
            $sql .= "id_cliente, cep, logradouro, numero, bairro, cidade, complemento, id_estado";
            $sql .= ") VALUES (";
            $sql .= ":id_cliente, :cep, :logradouro, :numero, :bairro, :cidade, :complemento, :id_estado)";

            $p_sql = Conexao::getConnection()->prepare($sql);

            $p_sql->bindValue(":id_cliente", $clienteEndereco->getIdCliente());
            $p_sql->bindValue(":cep", $clienteEndereco->getCep());
            $p_sql->bindValue(":logradouro", $clienteEndereco->getLogradouro());
            $p_sql->bindValue(":numero", $clienteEndereco->getNumero());
            $p_sql->bindValue(":bairro", $clienteEndereco->getBairro());
            $p_sql->bindValue(":cidade", $clienteEndereco->getCidade());
            $p_sql->bindValue(":complemento", $clienteEndereco->getComplemento());
            $p_sql->bindValue(":id_estado", $clienteEndereco->getIdEstado());

            return $p_sql->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir endereço do cliente: " . $e->getMessage());
        }
    }

    public function excluir($idCliente) {
        try {
            $sql = "DELETE FROM enderecocliente WHERE id_cliente = :idCliente";

            $p_sql = Conexao::getConnection()->prepare($sql);

            $p_sql->bindValue(":idCliente", $idCliente);

            return $p_sql->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir endereço do cliente: " . $e->getMessage());
        }
    }

}
