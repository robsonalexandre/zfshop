<?php

class FaturaMapper extends SON_Db_DataMapperAbstract {

    protected $_dbTable = "DbTable_Fatura";
    protected $_model = "Fatura";

    protected function _insert(SON_Db_DomainObjectAbstract $obj) {
        try {
            $dbTable = $this->getDbTable();
            $data = array(
                'pedido_id' => $obj->getPedido_id(),
                'produto_id' => $obj->getProduto_id(),
                'quantidade' => $obj->getQuantidade(),
                'valor' => $obj->getValor()
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
                'pedido_id' => $obj->getPedido_id(),
                'produto_id' => $obj->getProduto_id(),
                'quantidade' => $obj->getQuantidade(),
                'valor' => $obj->getValor()
            );

            $dbTable->update($data, array('id = ?' => $obj->getId()));
            return true;
        } catch (Zend_Exception $e) {
            return false;
        }
    }

}

