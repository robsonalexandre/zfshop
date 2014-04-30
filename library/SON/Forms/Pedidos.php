<?php

class SON_Forms_Pedidos extends Zend_Form {

    public function init() {
        $this->setMethod('post');

        $valor = $this->createElement('text', 'valor', array('label' => 'Valor:', 'class' => 'input-p', 'disabled' => 'disabled'));
        $this->addElement($valor);

        $forma = $this->createElement('text', 'forma', array('label' => 'Forma:', 'class' => 'input-m'));
        $this->addElement($forma);

        $status = new Zend_Form_Element_Select("status", array("label" => "Status:", "class" => "combo", 'style' => 'width: 185px;'));
        $dataStatus = array(
            0 => 'Não informado',
            1 => 'autorizado',
            2 => 'iniciado',
            3 => 'boleto impresso',
            4 => 'concluído',
            5 => 'cancelado',
            6 => 'em análise',
            7 => 'estornado',
        );
        $status->setMultiOptions($dataStatus);
        $this->addElement($status);

        $submit = $this->createElement('submit', 'submit', array('label' => 'Salvar', 'class' => 'input-p'));
        $this->addElement($submit);
    }

}