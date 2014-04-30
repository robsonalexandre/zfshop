<?php

class Default_AuthController extends Zend_Controller_Action {

    public function indexAction() {
        $form = new SON_Forms_AdminLogin();
        $this->view->form = $form;

        if($this->_request->isPost()) {
            $data = $this->_request->getPost();
            $authAdapter = $this->getAuthAdapter();
            $authAdapter->setIdentity($data["email"])
                    ->setCredential($data['senha']);

            $result = $authAdapter->authenticate();
            if($result->isValid()) {
                $auth = Zend_Auth::getInstance();
                $auth->setStorage(new Zend_Auth_Storage_Session("default"));
                $dataAuth = $authAdapter->getResultRowObject(null, 'senha');
                $auth->getStorage()->write($dataAuth);
                $this->_redirect("checkout");
            }
            else {
                $this->view->error = "usuário ou senha inválidos";
            }
        }
    }

    public function logoutAction() {
        $this->_helper->viewRenderer->setNoRender();
        $this->_helper->layout->disableLayout();
        $auth = Zend_Auth::getInstance();
        $auth->setStorage(new Zend_Auth_Storage_Session("default"));
        $auth->clearIdentity();
        $this->_redirect("index");
    }

    private function getAuthAdapter() {
        $bootstrap = $this->getInvokeArg("bootstrap");
        $resource = $bootstrap->getPluginResource("db");

        $db = $resource->getDbAdapter();

        $authAdapter = new Zend_Auth_Adapter_DbTable($db);
        $authAdapter->setTableName("clientes")
                ->setIdentityColumn("email")
                ->setCredentialColumn("senha")
                ->setCredentialTreatment('SHA1(?) and role <> ""');

        return $authAdapter;
    }

}

