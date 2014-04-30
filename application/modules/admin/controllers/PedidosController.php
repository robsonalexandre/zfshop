<?php

class Admin_PedidosController extends Zend_Controller_Action {

    public function indexAction() {
        $pedido = new Pedido();
        $data = $pedido->fetchAll();

        $paginator = Zend_Paginator::factory($data);
        $paginator->setCurrentPageNumber((int) $this->_getParam("page", 1));
        $paginator->setItemCountPerPage(10);

        $this->view->pedidos = $paginator;
    }

    public function editAction() {
        $pedido = new Pedido();
        $rpedido = $pedido->getAsArray((int) $this->_getParam("id"));

        $form = new SON_Forms_Pedidos();
        $form->addElement(new Zend_Form_Element_Hidden("id", $rpedido['id']));
        $form->populate($rpedido);
        $this->view->form = $form;

        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($form->isValid($data)) {
                $pedido = new Pedido($data);
                $pedido->save();
                $this->_redirect("admin/pedidos/");
            }
        }
    }

}

