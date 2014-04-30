<?php

class Admin_ClientesController extends Zend_Controller_Action {

    public function indexAction() {
        $cientes = new Cliente();
        $data = $cientes->fetchAll();

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber((int) $this->_getParam("page", 1));
        $paginator->setItemCountPerPage(10);

        $this->view->clientes = $paginator;
    }

    public function editAction() {
        $cliente = new Cliente();
        $rcliente = $cliente->getAsArray((int) $this->_getParam("id", 1));

        $form = new SON_Forms_Clientes();
        $form->addElement(new Zend_Form_Element_Hidden("id", $rcliente['id']));
        $form->populate($rcliente);
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $cliente = new Cliente($data);
                $cliente->save();
                $this->_redirect("admin/clientes/");
            }
        }
    }

}

