<?php

class Default_CarrinhoController extends Zend_Controller_Action {

    public function indexAction() {
        $carrinho = Carrinho::getInstance();
        $this->view->carrinho = $carrinho->fetchAll();
        $this->view->total = $carrinho->getTotal();
    }

    public function addAction() {
        $this->_helper->viewRenderer->setNoRender();
        $carrinho = Carrinho::getInstance();
        $carrinho->add((int) $this->_getParam("produto_id"));
        $this->_redirect("carrinho");
    }

    public function removeAction() {
        $this->_helper->viewRenderer->setNoRender();
        $carrinho = Carrinho::getInstance();
        $carrinho->remove((int) $this->_getParam("produto_id"));
        $this->_redirect("carrinho");
    }

    public function updateAction() {
        $this->_helper->viewRenderer->setNoRender();
        $qtds = $this->_getParam("qtd");
        $carrinho = Carrinho::getInstance();
        foreach($qtds as $produtoId=>$qtd) {
            $carrinho->changeQtd($produtoId, $qtd);
        }
        $this->_redirect("carrinho");

    }

}