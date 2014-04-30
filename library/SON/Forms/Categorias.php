<?php

class SON_Forms_Categorias extends Zend_Form {

    public function init() {
        $this->setMethod('post');

        $nome = $this->createElement('text', 'nome', array('label' => 'Nome:', 'class' => 'input-m'))->setRequired(true);
        $this->addElement($nome);

        $descricao = $this->createElement('text', 'descricao', array('label' => 'Descrição:', 'class' => 'input-g'))->setRequired(true);
        $this->addElement($descricao);

        $submit = $this->createElement('submit', 'submit', array('label' => 'Salvar', 'class' => 'input-p'));
        $this->addElement($submit);

    }

}