<?php

class SON_Plugins_Layout extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $layout = Zend_Layout::getMvcInstance ();
        $layout->setLayout("layout")->setLayoutPath(APPLICATION_PATH . '/modules/' . $request->getModuleName() . '/views/layouts');
    }

}