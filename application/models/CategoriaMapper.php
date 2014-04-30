<?php

class CategoriaMapper extends SON_Db_DataMapperAbstract {

    protected $_dbTable = "DbTable_Categoria";
    protected $_model = "Categoria";

    protected function _insert(SON_Db_DomainObjectAbstract $obj) {
        try {
            $dbTable = $this->getDbTable();
            $data = array(
                'nome' => $obj->getNome(),
                'descricao' => $obj->getdescricao()
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
                'descricao' => $obj->getDescricao()
            );

            $dbTable->update($data, array('id = ?' => $obj->getId()));
            return true;
        } catch (Zend_Exception $e) {
            return false;
        }
    }

    public function getNomeCategorias() {
        $db = $this->getDb();
        $query = $db->select();
        $query->from('categorias',array('id','nome'))
                ->order('nome asc');

        $data = $db->fetchPairs($query);
        return $data;
    }

}

