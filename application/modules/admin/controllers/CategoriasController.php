<?php

class Admin_CategoriasController extends Zend_Controller_Action {

    public function indexAction() {
        $categorias = new Categoria();
        $data = $categorias->fetchAll();

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber((int) $this->_getParam("page",1));
        $paginator->setItemCountPerPage(10);

        $this->view->categorias = $paginator;
    }

    public function addAction() {
        $form = new SON_Forms_Categorias();
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $categoria = new Categoria($data);
                $categoria->save();
                $this->_redirect("admin/categorias");
            }
        }

        $this->view->form = $form;
    }

    public function editAction() {
        $categoria = new Categoria();
        $rcategoria = $categoria->getAsArray((int) $this->_getParam("id"));

        $form = new SON_Forms_Categorias();
        $form->addElement(new Zend_Form_Element_Hidden("id", $rcategoria["id"]));
        $form->populate($rcategoria);
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $categoria = new Categoria($data);
                $categoria->save();
                $this->_redirect("admin/categorias");
            }
        }
    }

    public function deleteAction() {
        $categoria = new Categoria();
        if ((int) $this->_getParam("id") > 0)
            $categoria->delete((int) $this->_getParam("id"));

        $this->_helper->viewRenderer->setNoRender();
        $this->_redirect("admin/categorias");
    }

}

