<?php

class SON_Plugins_Welcome extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();
        $view = $viewRenderer->view;

        $auth = Zend_Auth::getInstance ();
        $auth->setStorage(new Zend_Auth_Storage_Session('default'));

        if ($auth->hasIdentity()) {
            $nome = $auth->getIdentity()->nome;
            $content = 'Seja bem-vindo, <b>' . $view->escape($nome) . '</b>';
            $content.= ' <i>(<a href="' . $view->url(array("controller" => "auth", "action" => "logout"), null, 1) . '">logout</a></i>)';
        } else {
            $content = 'Bem-vindo, faça seu <b><a href="' . $view->url(array("controller" => "auth", "action" => "index"), null, 1) . '">login</a></b>';
        }
        $view->placeholder('welcome')->append($content);
    }

}