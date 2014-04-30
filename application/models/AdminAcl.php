<?php

class AdminAcl extends Zend_Acl {

    public function  __construct() {

        // Papeis = Role = Grupos*
        $this->addRole(new Zend_Acl_Role("guest")); //visitante
        $this->addRole(new Zend_Acl_Role("user"),"guest"); // usuario logado na loja
        $this->addRole(new Zend_Acl_Role("pedidos"),"user"); // gerenciar pedidos e clientes
        $this->addRole(new Zend_Acl_Role("produtos"),"user"); // gerenciar prod. categ.
        $this->addRole(new Zend_Acl_Role("admin")); // faz tudo

        // Recursos
        $this->add(new Zend_Acl_Resource("admin:categorias"));
        $this->add(new Zend_Acl_Resource("admin:produtos"));
        $this->add(new Zend_Acl_Resource("admin:pedidos"));
        $this->add(new Zend_Acl_Resource("admin:clientes"));
        $this->add(new Zend_Acl_Resource("admin:auth"));

        // Privilegios
        $this->allow("guest","admin:auth", "index");

        $this->allow("user","admin:auth", "logout");
        $this->deny("user","admin:auth", "index");

        $this->allow("pedidos","admin:pedidos", array("index","edit"));
        $this->allow("pedidos","admin:clientes", array("index","edit"));

        $this->allow("produtos","admin:categorias", array("index","add","edit","delete"));
        $this->allow("produtos","admin:produtos", array("index","add","edit","delete"));

        $this->allow("admin");
        $this->deny("admin","admin:auth","index");



    }

}