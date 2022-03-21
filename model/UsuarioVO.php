<?php

class UsuarioVO {

    var $id;
    var $nome;
    var $login;
    var $senha;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getLogin() {
        return $this->login;
    }

    public function getSenha() {
        return $this->senha;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setLogin($login): void {
        $this->login = $login;
    }

    public function setSenha($senha): void {
        $this->senha = $senha;
    }

}
