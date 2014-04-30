<?php

class Default_IndexController extends Zend_Controller_Action {

    public function indexAction() {

        $produtos = new Produto();
        $rprodutos = $produtos->fetchAll();

        $paginator = Zend_Paginator::factory($rprodutos);
        $paginator->setDefaultItemCountPerPage(3);
        $paginator->setCurrentPageNumber((int) $this->_getParam("page",1));
        $this->view->produtos = $paginator;

    }

}

