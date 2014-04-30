<?php

class SON_Forms_AdminLogin extends Zend_Form {
    
    public function init() {
        
        $this->setMethod("post");

        $email = $this->createElement("text", "email",array("label"=>"Email:","class"=>"input-g"))
                ->setRequired(true);
        $this->addElement($email);
        
        $senha = $this->createElement("password", "senha",array("label"=>"Senha:","class"=>"input-g"))
                ->setRequired(true);
        $this->addElement($senha);
        
        $submit = $this->createElement("submit", "submit",array("label"=>"Login","class"=>"input-p"));
        $this->addElement($submit);

        $this->addElement("hash","csrf");
        
    }

}