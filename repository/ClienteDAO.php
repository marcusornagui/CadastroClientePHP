<?php

require_once('../model/ClienteVO.php');
require_once('../repository/Conexao.php');

class ClienteDAO {

    public static $instance;

    public function __construct() {
        
    }

    public function inserir(ClienteVO $cliente) {
        try {
            $sql = "INSERT INTO cliente (";
            $sql .= "nome, datanascimento, cpf, rg, telefone";
            $sql .= ") VALUES (";
            $sql .= ":nome, :datanascimento, :cpf, :rg,:telefone)";

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

}
