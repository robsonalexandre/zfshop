<?php

class Default_ClientesController extends Zend_Controller_Action {

    public function indexAction() {
        
    }

    public function addAction() {

        $this->_helper->viewRenderer->setNoRender();

        $form = new SON_Forms_ClientesCadastro();
        $form->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . "/clientes/add");
        $form->addElement(new Zend_Form_Element("password", "senha", array('label' => 'Senha', 'class' => 'input-p')));

        $this->view->formCliente = $form;

        if($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if($form->isValid($data)) {
                $data['role'] = "user";
                $cliente = new Cliente($data);
                $cliente->save();
                $this->_redirect("auth");
            }
        }
    }

}