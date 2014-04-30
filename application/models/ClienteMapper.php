<?php

class ClienteMapper extends SON_Db_DataMapperAbstract {

    protected $_dbTable = "DbTable_Cliente";
    protected $_model = "Cliente";

    protected function _insert(SON_Db_DomainObjectAbstract $obj) {
        try {
            $dbTable = $this->getDbTable();
            $data = array(
                'nome' => $obj->getNome(),
                'email' => $obj->getEmail(),
                'senha' => $obj->getSenha(),
                'ddd' => $obj->getDdd(),
                'telefone' => $obj->getTelefone(),
                'complemento' => $obj->getComplemento(),
                'cep' => $obj->getCep(),
                'rua' => $obj->getRua(),
                'numero' => $obj->getNumero(),
                'bairro' => $obj->getBairro(),
                'cidade' => $obj->getCidade(),
                'estado' => $obj->getEstado(),
                'role' => $obj->getRole()
            );
            $dbTable->insert($data);
            return true;
        } catch (Zend_Exception $e) {
            return false;
        }
    }

    protected function _update(SON_Db_DomainObjectAbstract $obj) {
        try {
            $dbTable = $this->getDbTable();
            $data = array(
                'nome' => $obj->getNome(),
                'email' => $obj->getEmail(),
                'ddd' => $obj->getDdd(),
                'telefone' => $obj->getTelefone(),
                'cep' => $obj->getCep(),
                'rua' => $obj->getRua(),
                'complemento' => $obj->getComplemento(),
                'numero' => $obj->getNumero(),
                'bairro' => $obj->getBairro(),
                'cidade' => $obj->getCidade(),
                'estado' => $obj->getEstado()
            );

            $dbTable->update($data, array('id = ?' => $obj->getId()));
            if ($obj->getSenha() <> "" and $obj->getSenha() <> "da39a3ee5e6b4b0d3255bfef95601890afd80709") {
                $data = array('senha' => $obj->getSenha());
                $dbTable->update($data, array('id = ?' => $obj->getId()));
            }
            if ($obj->getRole() <> "") {
                $data = array('role' => $obj->getRole());
                $dbTable->update($data, array('id = ?' => $obj->getId()));
            }
            return true;
        } catch (Zend_Exception $e) {
            return false;
        }
    }

}

