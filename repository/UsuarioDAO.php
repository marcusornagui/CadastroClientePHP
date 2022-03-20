<?php

require_once('../repository/Conexao.php');

class UsuarioDAO {

    public static $instance;

    public function __construct() {
        
    }

    public function autenticar($login, $senha) {
        try {
            $sql = "SELECT id";
            $sql .= " FROM usuario";
            $sql .= " WHERE login = :login";
            $sql .= " AND senha = :senha";

            $p_sql = Conexao::getConnection()->prepare($sql);
            $p_sql->bindValue(":login", $login);
            $p_sql->bindValue(":senha", $senha);

            $p_sql->execute();

            $result = 0;
            
            if ($p_sql->rowCount() > 0) {
                $result = $p_sql->fetch(PDO::FETCH_OBJ)->id;
            }
            
            return $result;
        } catch (Exception $e) {
            throw new Exception("Erro ao carregar usuário: " . $e->getMessage());
        }
    }

}
