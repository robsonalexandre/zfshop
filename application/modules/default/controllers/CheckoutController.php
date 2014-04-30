<?php

class Default_CheckoutController extends Zend_Controller_Action {

    public function indexAction() {
        $carrinho = Carrinho::getInstance();
        Zend_Session::regenerateId();

        if (!$carrinho->isEmpty()) {
            $form = new SON_Forms_AdminLogin();
            $form->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . "/auth");
            $this->view->form = $form;

            $formCliente = new SON_Forms_ClientesCadastro();
            $formCliente->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . "/clientes/add");
            $this->view->formCliente = $formCliente;

            $this->view->carrinho = $carrinho->fetchAll();
            $this->view->total = $carrinho->getTotal();
        }
        else
            $this->_redirect("carrinho");
    }

    public function finishAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();

        $auth = Zend_Auth::getInstance()
                        ->setStorage(new Zend_Auth_Storage_Session("default"));

        if($auth->hasIdentity()) {
            if($this->_request->isPost()) {
                $data = $this->_request->getPost();

                $carrinho = Carrinho::getInstance();
                $config = new Zend_Config_Ini(APPLICATION_PATH ."/configs/moip.ini",'moip');

                $userToken = $config->token;
                $key = $config->key;

                $id = $auth->getIdentity()->id;

                $cliente = new Cliente();
                $rcliente = $cliente->find($id);

                $pedido = new Pedido();
                $pedido_id = $pedido->geraPedido($rcliente, $carrinho);

                $moip = new PagamentoMoip();
                $xml = $moip->generateXML($rcliente, $carrinho, $pedido_id, $data['frete']);

                $token = $moip->getToken($userToken, $key, $xml);

                if($token) {
                    $url = $moip->generateUrl($token);
                    $carrinho = Carrinho::getInstance();
                    //$carrinho->clear();
                    $this->_redirect($url);
                }
            }
        }
    }

}