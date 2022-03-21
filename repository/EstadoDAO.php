<?php
require_once('../Sessao.php');
require_once('../repository/Conexao.php');

class EstadoDAO {

    public static $instance;

    public function __construct() {
        
    }

    public function consultar() {
        try {
            $sql = "SELECT id, descricao, sigla";
            $sql .= " FROM estado";
            $sql .= " ORDER BY sigla";

            $p_sql = Conexao::getConnection()->prepare($sql);
            $p_sql->execute();

            $result = $p_sql->fetchAll(PDO::FETCH_ASSOC);

            return !empty($result) ? $result : array();
        } catch (Exception $e) {
            throw new Exception("Erro ao consultar estado: " . $e->getMessage());
        }
    }

    

}
