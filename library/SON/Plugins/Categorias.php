<?php

class SON_Plugins_Categorias extends Zend_Controller_Plugin_Abstract {

    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();
        $view = $viewRenderer->view;

        $categoria = new Categoria();
        $categorias = $categoria->fetchAll();

        $content = "<ul>";
        foreach ($categorias as $c)
            $content.= "<li><a href='" . $view->url(array('controller' => 'produtos', 'action' => 'list', 'module' => 'default', 'categoria_id' => $c->getId(), 'categoria' => $c->getNome()), false, 1) . "'>" . $view->escape($c->getNome()) . "</a></li>";

        $content.= "</ul>";


        $view->placeholder('categorias')->append($content);
    }

}
