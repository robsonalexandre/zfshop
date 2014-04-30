<?php

class Pedido extends SON_Db_DomainObjectAbstract {

    protected $_mapper = "PedidoMapper";
    private $valor = null;
    private $forma = null;
    private $status = null;
    private $cliente_id = null;
    private $datahora = null;

    public function getCliente_id() {
        return $this->cliente_id;
    }

    public function setCliente_id($cliente_id) {
        $this->cliente_id = $cliente_id;
    }

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getForma() {
        return $this->forma;
    }

    public function setForma($forma) {
        $this->form = $forma;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }

    public function getDatahora() {
        return $this->datahora;
    }

    public function setDatahora($datahora) {
        $this->datahora = $datahora;
    }

    
    public function geraPedido(Cliente $cliente, Carrinho $carrinho) {

        return $this->getMapper()->geraPedido($cliente, $carrinho);
    }

}

