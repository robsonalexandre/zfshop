<?php

class PedidoMapper extends SON_Db_DataMapperAbstract {

    protected $_dbTable = "DbTable_Pedido";
    protected $_model = "Pedido";

    protected function _insert(SON_Db_DomainObjectAbstract $obj) {
        try {
            $dbTable = $this->getDbTable();
            $data = array(
                'cliente_id' => $obj->getCliente_id(),
                'valor' => $obj->getValor(),
                'forma' => $obj->getForma(),
                'status' => $obj->getStatus(),
                'datahora' => date("Y-m-d H:i:s")
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
                'forma' => $obj->getForma(),
                'status' => $obj->getStatus()
            );

            $dbTable->update($data, array('id = ?' => $obj->getId()));
            return true;
        } catch (Zend_Exception $e) {
            return false;
        }
    }

    public function geraPedido(Cliente $cliente, Carrinho $carrinho) {

        $db = $this->getDb();
        $db->beginTransaction();
        try {
            $valor = $carrinho->getTotal();
            $cliente_id = $cliente->getId();

            $dataPedido = array('valor' => $valor, 'cliente_id' => $cliente_id);
            $pedido = new Pedido($dataPedido);
            $pedido->save();

            $pedido_id = $pedido->getLastInsertId();

            $produtos_carrinho = $carrinho->fetchAll();
            foreach ($produtos_carrinho as $produto) {
                $produto_id = $produto['produto']->getId();
                $produto_valor = $produto['produto']->getValor();
                $produto_quantidade = $produto['qtd'];
                $dataFatura = array('pedido_id' => $pedido_id,
                    'produto_id' => $produto_id,
                    'quantidade' => $produto_quantidade,
                    'valor' => $produto_valor);
                $fatura = new Fatura($dataFatura);
                $fatura->save();
            }

            $db->commit();
            return $pedido_id;
        } catch (Zend_Exception $e) {
            $db->rollBack();
        }
    }

    public function fetchAll() {
        $db = $this->getDb();
        $query = $db->select();
        $query->from('pedidos');
        $pedidos = $db->fetchAll($query);

        $objArray = array();
        $cliente = new Cliente();
        foreach ($pedidos as $pedido) {
            $pedido['cliente_id'] = $cliente->find($pedido['cliente_id']);
            $objArray[] = $this->_populate($pedido);
        }

        return $objArray;
    }

}

