<?php

require_once('../model/ClienteVO.php');
require_once('../repository/Conexao.php');

class ClienteDAO {

    public static $instance;

    public function __construct() {
        
    }

    public function consultar() {
        try {
            $sql = "SELECT id, nome, datanascimento, cpf, rg, telefone";
            $sql .= " FROM cliente";
            $sql .= " ORDER BY nome";
            
            $p_sql = Conexao::getConnection()->prepare($sql);
            $p_sql->execute();

            $result = $p_sql->fetchAll(PDO::FETCH_ASSOC);

            return !empty($result) ? $result : array();
            
        } catch (Exception $e) {
            throw new Exception("Erro ao consultar cliente: " . $e->getMessage());
        }
    }

    public function idExiste($id) {
        try {
            $sql = "SELECT id FROM cliente WHERE id = " . $id;

            $p_sql = Conexao::getConnection()->prepare($sql);
            $p_sql->execute();

            if ($p_sql->rowCount() == 0) {
                return false;
            } else {
                return true;
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir cliente: " . $e->getMessage());
        }
    }

    public function inserir(ClienteVO $cliente) {
        try {
            $sql = "INSERT INTO cliente (";
            $sql .= "nome, datanascimento, cpf, rg, telefone";
            $sql .= ") VALUES (";
            $sql .= ":nome, :datanascimento, :cpf, :rg, :telefone)";

            $p_sql = Conexao::getConnection()->prepare($sql);

            $p_sql->bindValue(":nome", $cliente->getNome());
            $p_sql->bindValue(":datanascimento", $cliente->getDataNascimento());
            $p_sql->bindValue(":cpf", $cliente->getCpf());
            $p_sql->bindValue(":rg", $cliente->getRg());
            $p_sql->bindValue(":telefone", $cliente->getTelefone());

            return $p_sql->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao inserir cliente: " . $e->getMessage());
        }
    }

    public function alterar(ClienteVO $cliente) {
        try {
            $sql = "UPDATE cliente SET";
            $sql .= " nome = :nome,";
            $sql .= " datanascimento = :datanascimento,";
            $sql .= " cpf = :cpf,";
            $sql .= " rg = :rg,";
            $sql .= " telefone = :telefone";
            $sql .= " WHERE id = :id";

            $p_sql = Conexao::getConnection()->prepare($sql);

            $p_sql->bindValue(":id", $cliente->getId());
            $p_sql->bindValue(":nome", $cliente->getNome());
            $p_sql->bindValue(":datanascimento", $cliente->getDataNascimento());
            $p_sql->bindValue(":cpf", $cliente->getCpf());
            $p_sql->bindValue(":rg", $cliente->getRg());
            $p_sql->bindValue(":telefone", $cliente->getTelefone());

            return $p_sql->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao alterar cliente: " . $e->getMessage());
        }
    }
    
    public function excluir($id) {
        try {
            $sql = "DELETE FROM cliente WHERE id = :id";

            $p_sql = Conexao::getConnection()->prepare($sql);

            $p_sql->bindValue(":id", $id);

            return $p_sql->execute();
        } catch (Exception $e) {
            throw new Exception("Erro ao excluir cliente: " . $e->getMessage());
        }
    }

}
