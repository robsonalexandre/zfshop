<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap {

    protected function _initSessions() {
        Zend_Session::setOptions(array(
            'cookie_httponly' => true)
        );

        Zend_Session::start();
    }

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        if ($bootstrap instanceof Zend_Application) {
            $bootstrap = $this;
        }
        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource('FrontController');

        $front->registerPlugin(new SON_Plugins_Welcome());
        $front->registerPlugin(new SON_Plugins_Categorias());
    }

}