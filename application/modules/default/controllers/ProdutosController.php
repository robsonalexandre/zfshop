<?php

class Default_ProdutosController extends Zend_Controller_Action {

    public function indexAction() {

    }

    public function listAction() {

        $produto = new Produto();
        $produtos = $produto->getByCategoriaId((int) $this->_getParam("categoria_id"));

        $categoria = new Categoria();
        $this->view->categoria = $categoria->find((int) $this->_getParam("categoria_id"));

        $paginator = Zend_Paginator::factory($produtos);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->_getParam("page", 1));
        $this->view->produtos = $paginator;
    }

    public function viewAction() {
        $produto = new Produto();
        $rproduto = $produto->find((int) $this->_getParam("id"));
        if ($rproduto)
            $this->view->produto = $rproduto;
    }

}