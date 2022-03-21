<?php

class ClienteEnderecoVO {

    var $id;
    var $idCliente;
    var $cep;
    var $logradouro;
    var $numero;
    var $bairro;
    var $cidade;
    var $complemento;
    var $idEstado;

    public function getId() {
        return $this->id;
    }

    public function getIdCliente() {
        return $this->idCliente;
    }

    public function getCep() {
        return $this->cep;
    }

    public function getLogradouro() {
        return $this->logradouro;
    }

    public function getNumero() {
        return $this->numero;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function getCidade() {
        return $this->cidade;
    }

    public function getComplemento() {
        return $this->complemento;
    }

    public function getIdEstado() {
        return $this->idEstado;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setIdCliente($idCliente): void {
        $this->idCliente = $idCliente;
    }

    public function setCep($cep): void {
        $this->cep = $cep;
    }

    public function setLogradouro($logradouro): void {
        $this->logradouro = $logradouro;
    }

    public function setNumero($numero): void {
        $this->numero = $numero;
    }

    public function setBairro($bairro): void {
        $this->bairro = $bairro;
    }

    public function setCidade($cidade): void {
        $this->cidade = $cidade;
    }

    public function setComplemento($complemento): void {
        $this->complemento = $complemento;
    }

    public function setIdEstado($idEstado): void {
        $this->idEstado = $idEstado;
    }

}
