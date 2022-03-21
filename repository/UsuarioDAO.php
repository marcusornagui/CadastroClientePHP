<?php

require_once('../repository/Conexao.php');
require_once('../model/UsuarioVO.php');

class UsuarioDAO {

    public static $instance;

    public function __construct() {
        
    }

    public function autenticar($login, $senha) {
        try {
            $sql = "SELECT id, nome, login";
            $sql .= " FROM usuario";
            $sql .= " WHERE login = :login";
            $sql .= " AND senha = :senha";

            $p_sql = Conexao::getConnection()->prepare($sql);
            $p_sql->bindValue(":login", $login);
            $p_sql->bindValue(":senha", $senha);

            $p_sql->execute();

            $usuario = new UsuarioVO();

            while ($result = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                $usuario->setId($result['id']);
                $usuario->setNome($result['nome']);
                $usuario->setLogin($result['login']);
            }

            return $usuario;
        } catch (Exception $e) {
            throw new Exception("Erro ao carregar usuário: " . $e->getMessage());
        }
    }

}
