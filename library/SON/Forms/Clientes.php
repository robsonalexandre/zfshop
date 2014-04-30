<?php

class SON_Forms_Clientes extends Zend_Form {

    public function init() {
        $this->setMethod('post');

        $nome = $this->createElement('text', 'nome', array('label' => 'Nome:', 'class' => 'input-g'))->setRequired(true);
        $this->addElement($nome);

        $email = $this->createElement('text', 'email', array('label' => 'Email:', 'class' => 'input-m'))->setRequired(true);
        $this->addElement($email);

        $ddd = $this->createElement('text', 'ddd', array('label' => 'DDD:', 'class' => 'input-p'))->setRequired(true);
        $this->addElement($ddd);

        $telefone = $this->createElement('text', 'telefone', array('label' => 'Telefone:', 'class' => 'input-m'))->setRequired(true);
        $this->addElement($telefone);

        $cep = $this->createElement('text', 'cep', array('label' => 'CEP:', 'class' => 'input-m'))->setRequired(true);
        $this->addElement($cep);

        $rua = $this->createElement('text', 'rua', array('label' => 'Rua:', 'class' => 'input-g'))->setRequired(true);
        $this->addElement($rua);

        $numero = $this->createElement('text', 'numero', array('label' => 'Número:', 'class' => 'input-p'))->setRequired(true);
        $this->addElement($numero);

        $complemento = $this->createElement('text', 'complemento', array('label' => 'Complemento:', 'class' => 'input-g'));
        $this->addElement($complemento);

        $bairro = $this->createElement('text', 'bairro', array('label' => 'Bairro:', 'class' => 'input-m'))->setRequired(true);
        $this->addElement($bairro);

        $cidade = $this->createElement('text', 'cidade', array('label' => 'Cidade:', 'class' => 'input-g'))->setRequired(true);
        $this->addElement($cidade);

        //Estados
        $estado = $this->createElement('select', 'estado', array('label' => 'Estado', 'class' => 'combo', 'style' => 'width: 150px;height: 25px;margin-top: 5px;'))->setRequired(true);
        $arEstados = array('AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazônas', 'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Distrito Federal', 'ES' => 'Espírito Santo', 'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul', 'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná', 'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte', 'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina', 'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins');
        $estado->addMultiOptions($arEstados);
        $this->addElement($estado);

        if (Zend_Registry::get('role') == "admin") {
            $role = $this->createElement('select', 'role', array('label' => 'Papel:', 'class' => 'combo', 'style' => 'width: 200px;height: 25px;margin-top: 5px;'))->setRequired(true);
            $status = array('admin' => 'Administrador', 'pedidos' => 'Gerenciamento de Pedidos', 'produtos' => 'Gerenciamento de Produtos', 'user' => 'Usuário');
            $role->addMultiOptions($status);
            $this->addElement($role);
        }



        $submit = $this->createElement('submit', 'submit', array('label' => 'Salvar', 'class' => 'input-p'));
        $this->addElement($submit);
    }

}