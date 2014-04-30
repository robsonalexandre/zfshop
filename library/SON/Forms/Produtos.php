<?php

class SON_Forms_Produtos extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

        $categoria = new Zend_Form_Element_Select("categoria_id", array("label"=>"Categoria:","class"=>"combo",'style'=>'width: 155px;'));
        $categorias = new Categoria();
        $dataCategorias = $categorias->getNomeCategorias();
        $categoria->setMultiOptions($dataCategorias);
        
        $this->addElement($categoria);

        $nome = $this->createElement('text', 'nome', array('label' => 'Nome:', 'class' => 'input-gg'))->setRequired(true);
        $this->addElement($nome);

        $descricao = $this->createElement('textarea', 'descricao', array('label' => 'Descrição:','class' => 'jquery_ckeditor', 'style' => 'width: 500px; height: 200px' ))->setRequired(true);
        $this->addElement($descricao);

        $valor = $this->createElement('text', 'valor', array('label' => 'Valor:', 'class' => 'input-p'))->setRequired(true);
        $this->addElement($valor);

        $valorPromocao = $this->createElement('text', 'valor_promocao', array('label' => 'Vlr Promoção:', 'class' => 'input-p'));
        $this->addElement($valorPromocao);

        $peso = $this->createElement('text', 'peso', array('label' => 'Peso:', 'class' => 'input-p'))->setRequired(true);
        $this->addElement($peso);

        $estoque = $this->createElement('text', 'estoque', array('label' => 'Estoque:', 'class' => 'input-p'))->setRequired(true);
        $this->addElement($estoque);

        $image = new Zend_Form_Element_File('image');
        $image->setLabel('Imagem: ');
        $image->setDestination('images/produtos/')->setValueDisabled(true);
        $image->addValidator('Extension', false, 'jpg,png,gif');
        $image->addValidator('Size', false, '500kB');
        $image->addValidator('Count', false, 1);
        $this->addElement($image);

        $submit = $this->createElement('submit', 'submit', array('label' => 'Salvar', 'class' => 'input-p'));
        $this->addElement($submit);

    }

}