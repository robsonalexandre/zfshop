<?php

class Fatura extends SON_Db_DomainObjectAbstract {

    protected $_mapper = "FaturaMapper";
    private $pedido_id = null;
    private $produto_id = null;
    private $quantidade = null;
    private $valor = null;

    public function getPedido_id() {
        return $this->pedido_id;
    }

    public function setPedido_id($pedido_id) {
        $this->pedido_id = $pedido_id;
    }

    public function getProduto_id() {
        return $this->produto_id;
    }

    public function setProduto_id($produto_id) {
        $this->produto_id = $produto_id;
    }

    public function getQuantidade() {
        return $this->quantidade;
    }

    public function setQuantidade($quantidade) {
        $this->quantidade = $quantidade;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }



}

