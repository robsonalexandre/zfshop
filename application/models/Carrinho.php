<?php

class Carrinho {

    private static $_instance = null;
    private $_carrinho = null;

    public static function getInstance() {
        if (!isset(self::$_instance)) {
            $c = __CLASS__;
            self::$_instance = new $c;
        }

        return self::$_instance;
    }

    public function __construct() {
        $this->_carrinho = new Zend_Session_Namespace("carrinho");
        if (!isset($this->_carrinho->initialized)) {
            Zend_Session::regenerateId();
            $this->_carrinho->initialized = true;
        }
    }

    public function add($produtoId) {
        if (!isset($this->_carrinho->produto[(int) $produtoId])) {
            $this->_carrinho->produto[(int) $produtoId] = 1;
        } else {
            $qtd+= $this->_carrinho->produto[(int) $produtoId];
            $produto = new Produto();
            $p = $produto->find($produtoId);
            if ($p->getEstoque() >= $qtd)
                $this->_carrinho->produto[(int) $produtoId] = $qtd;
        }
    }

    public function remove($produtoId) {
        if (isset($this->_carrinho->produto[(int) $produtoId])) {
            unset($this->_carrinho->produto[(int) $produtoId]);
        }
    }

    public function changeQtd($produtoId, $qtd) {
        $produto = new Produto();
        $p = $produto->find($produtoId);
        if ($p->getEstoque() >= $qtd)
            $this->_carrinho->produto[(int) $produtoId] = (int) $qtd;
    }

    public function fetchAll() {
        $produto = new Produto();
        $objArray = array();
        $i = 0;
        if (count($this->_carrinho->produto)) {
            foreach ($this->_carrinho->produto as $produto_id => $qtd) {
                $objArray[$i]['produto'] = $produto->find($produto_id);
                $objArray[$i]['qtd'] = $qtd;
                $i++;
            }
        }
        return $objArray;
    }

    public function getTotal() {
        $produto = new Produto();
        $total = 0;
        if (count($this->_carrinho->produto)) {
            foreach ($this->_carrinho->produto as $produto_id => $qtd) {
                $p = $produto->find($produto_id);
                $total+= $p->getValor() * $qtd;
            }
        }
        return $total;
    }

    public function getTotalPeso() {
        $produto = new Produto();
        $total = 0;
        foreach ($this->_carrinho->produto as $produto_id => $qtd) {
            $p = $produto->find($produto_id);
            $total+= $p->getPeso() * $qtd;
        }
        return round($total);
    }

    public function isEmpty() {
        if (!count($this->_carrinho->produto))
            return true;
    }

    public function clear() {
        unset($this->_carrinho->produto);
        Zend_Session::regenerateId();
    }

}

