<?php

class ClienteVO {

    var $id;
    var $nome;
    var $dataNascimento;
    var $cpf;
    var $rg;
    var $telefone;
    var $clienteEndereco;

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function getCpf() {
        return $this->cpf;
    }

    public function getRg() {
        return $this->rg;
    }

    public function getTelefone() {
        return $this->telefone;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setNome($nome): void {
        $this->nome = $nome;
    }

    public function setDataNascimento($dataNascimento): void {
        $this->dataNascimento = $dataNascimento;
    }

    public function setCpf($cpf): void {
        $this->cpf = $cpf;
    }

    public function setRg($rg): void {
        $this->rg = $rg;
    }

    public function setTelefone($telefone): void {
        $this->telefone = $telefone;
    }

    public function getClienteEndereco() {
        return $this->clienteEndereco;
    }

    public function setClienteEndereco($clienteEndereco): void {
        $this->clienteEndereco = $clienteEndereco;
    }

}
