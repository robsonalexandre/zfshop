<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initViews() {
        $this->bootstrap('view');
        $view = $this->getResource("view");

        $view->doctype("HTML5");
        Zend_Registry::set('view',$view);

        $view->addHelperPath("ZendX/JQuery/View/Helper","ZendX_JQuery_View_Helper");

        $currency = new Zend_Currency("pt_BR");
        $currency->setFormat(array('symbol' => "R$ "));
        Zend_Registry::set("currency", $currency);

        $view->headTitle()->setSeparator(" - ")->headTitle("ZFShop");
        $view->headMeta()->appendHttpEquiv("Content-type","text/html;charset=utf-8");
    }

    protected function _initAutoLoader() {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        /*
        $autoloader->registerNamespace("ZendX");
        $autoloader->registerNamespace("SON");
        $autoloader->registerNamespace("IDS");
         */
        $autoloader->setFallbackAutoloader(true); // pega tudo
    }

    protected function _initPlugins() {
        $bootstrap = $this->getApplication();
        if($bootstrap instanceof Zend_Application)
            $bootstrap = $this;

        $bootstrap->bootstrap('FrontController');
        $front = $bootstrap->getResource("FrontController");

        $front->registerPlugin(new SON_Plugins_Layout());
        $front->registerPlugin(new SON_Plugins_IDS());
        
    }

}

