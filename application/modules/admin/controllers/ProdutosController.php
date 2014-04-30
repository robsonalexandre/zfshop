<?php

class Admin_ProdutosController extends Zend_Controller_Action {

    public function indexAction() {
        $produtos = new Produto();
        $data = $produtos->fetchAll();

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber((int) $this->_getParam("page", 1));
        $paginator->setItemCountPerPage(10);

        $this->view->produtos = $paginator;
        $this->view->currency = Zend_Registry::get('currency');
    }

    public function addAction() {
        $form = new SON_Forms_Produtos();

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {

                $produto = new Produto($data);
                $produto->save();

                $file = $produto->getLastInsertId().".jpg";
                $image = $form->getElement('image');

                $image->addFilter('Rename', array('target' => 'images/produtos/' . $file));
                $image->receive();
                
                $this->_redirect("admin/produtos/");
            }
        }

        $this->view->form = $form;
    }

    public function editAction() {
        $produto = new Produto();
        $rproduto = $produto->getAsArray((int) $this->_getParam("id", 1));

        $form = new SON_Forms_Produtos();
        $form->addElement(new Zend_Form_Element_Hidden("id", $rproduto['id']));
        $form->populate($rproduto);
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $produto = new Produto($data);
                $produto->save();

                $file = $produto->getId().".jpg";
                $image = $form->getElement('image');

                $image->addFilter('Rename', array('target' => 'images/produtos/' . $file));
                $image->receive();

                $this->_redirect("admin/produtos/");
            }
        }
    }

    public function deleteAction() {
        $produto = new Produto();
        if ((int) $this->_getParam("id") > 0)
            $produto->delete((int) $this->_getParam("id"));

        $this->_helper->viewRenderer->setNoRender();
        $this->_redirect("admin/produtos/");
    }

}

