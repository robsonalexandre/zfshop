<?php

abstract class SON_Db_DataMapperAbstract {

    private static $_db = null;
    protected $_dbTable = null;
    protected $_model = null;

    public function getDb() {
        if (is_null(self::$_db))
            self::$_db = Zend_Db_Table::getDefaultAdapter();
        return self::$_db;
    }

    public function getDbTable() {
        $this->_dbTable = new $this->_dbTable;
        if (!$this->_dbTable instanceof Zend_Db_Table_Abstract)
            throw new Exception('Tipo inválido de tabela');
        return $this->_dbTable;
    }

    public function save(SON_Db_DomainObjectAbstract $obj) {
        if (is_null($obj->getId()))
            $this->_insert($obj);
        else
            $this->_update($obj);
    }

    public function fetchAll(Zend_Db_Select $select = null) {
        $dbTable = $this->getDbTable();
        $db = $this->getDb();
        $data = (!is_null($select)) ? $db->fetchAll($select) : $dbTable->fetchAll();
        $dataObjArray = array();
        foreach ($data as $row)
            $dataObjArray[] = $this->_populate($row);
        return $dataObjArray;
    }

    public function find($id) {
        $result = $this->getDbTable()->find((int) $id);
        if (0 == count($result))
            return false;
        $row = $result->current();
        return $this->_populate($row);
    }

    public function getAsArray($id) {
        $result = $this->getDbTable()->find((int) $id);
        if (0 == count($result))
            return false;
        $row = $result->current();
        return $row->toArray();
    }

    public function delete($id) {
        $result = $this->getDbTable()->find((int) $id);
        if (0 == count($result))
            return false;
        $row = $result->current();
        return $row->delete();
    }

    protected function _populate($data) {
        $obj = new $this->_model;
        foreach ($data as $k => $v) {
            $method = 'set' . ucfirst($k);
            if (!method_exists($obj, $method)) {
                throw new Exception('Invalid property - ' . $method);
            }
            $obj->$method($v);
        }
        return $obj;
    }

    public function getLastInsertId(){
        $db = $this->getDb();
        return $db->lastInsertId();
    }

    abstract protected function _insert(SON_Db_DomainObjectAbstract $obj);

    abstract protected function _update(SON_Db_DomainObjectAbstract $obj);
}