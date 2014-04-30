<?php

class Default_RetornoController extends Zend_Controller_Action {

    public function indexAction() {
        if ($this->_request->isPost()) {
            $data = $this->_request->getPost();
            if ($data['sec'] == 123) {
                $pedido = new Pedido();
                $pedido->setId($data ['id_transacao']);
                $pedido->setStatus($data['status_pagamento']);
                $pedido->setForma($data['forma_pagamento']);
                $pedido->save();
                if ($pedido->getStatus() == 1)
                    header("HTTP/1.1 200 OK");
            }
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
    }
}