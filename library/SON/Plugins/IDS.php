<?php

class SON_Plugins_IDS extends Zend_Controller_Plugin_Abstract {

    public function preDispatch(Zend_Controller_Request_Abstract $request) {
        require_once 'IDS/Init.php';
        $request = array('REQUEST' => $_REQUEST, 'GET' => $_GET, 'POST' => $_POST, 'COOKIE' => $_COOKIE);
        $init = IDS_Init::init(APPLICATION_PATH . '/../library/IDS/Config/Config.ini.php');

        $ids = new IDS_Monitor($request, $init);
        $result = $ids->run();

        if (!$result->isEmpty()) {
            #die("Ops! Você não pode fazer essa operação!");
            echo $result;
            die;
        }
        return $request;
    }

}