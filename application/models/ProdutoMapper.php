<?php

class ProdutoMapper extends SON_Db_DataMapperAbstract {

    protected $_dbTable = "DbTable_Produto";
    protected $_model = "Produto";

    protected function _insert(SON_Db_DomainObjectAbstract $obj) {
        try {
            $dbTable = $this->getDbTable();
            $data = array(
                'nome' => $obj->getNome(),
                'descricao' => $obj->getDescricao(),
                'valor' => $obj->getValor(),
                'valor_promocao' => $obj->getValor_promocao(),
                'peso' => $obj->getPeso(),
                'estoque' => $obj->getEstoque(),
                'categoria_id' => $obj->getCategoria_id()
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
                'descricao' => $obj->getDescricao(),
                'valor' => $obj->getValor(),
                'valor_promocao' => $obj->getValor_promocao(),
                'peso' => $obj->getPeso(),
                'estoque' => $obj->getEstoque(),
                'categoria_id' => $obj->getCategoria_id()
            );

            $dbTable->update($data, array('id = ?' => $obj->getId()));
            return true;
        } catch (Zend_Exception $e) {
            return false;
        }
    }

    public function find($id) {
        $db = $this->getDb();
        $query = $db->select();
        $query->from('produtos')
                ->where('id = ' . (int) $id);

        $data = $db->fetchRow($query);

        if ($data) {
            $categoriaMapper = new CategoriaMapper();
            $categoria = $categoriaMapper->find($data['categoria_id']);
            $data['categoria_id'] = $categoria;
            return $this->_populate($data);
        }
    }

     public function fetchAll() {
        $db = $this->getDb();
        $query = $db->select();
        $query->from('produtos')
                ->order('nome asc');
        
        $produtos = $db->fetchAll($query);

        $objArray = array();
        $categoriaMapper = new CategoriaMapper();

        foreach ($produtos as $produto) {
            $categoria = $categoriaMapper->find($produto['categoria_id']);
            $produto['categoria_id'] = $categoria;
            $objArray[] = $this->_populate($produto);
        }

        return $objArray;
    }

    public function getByCategoriaId($id) {
        $db = $this->getDb();
        $query = $db->select();
        $query->from('produtos')
                ->where('categoria_id = ' . (int) $id);
        
        $produtos = $db->fetchAll($query);

        $objArray = array();
        $categoriaMapper = new CategoriaMapper();

        foreach ($produtos as $produto) {
            $categoria = $categoriaMapper->find($produto['categoria_id']);
            $produto['categoria_id'] = $categoria;
            $objArray[] = $this->_populate($produto);
        }

        return $objArray;
    }

}

