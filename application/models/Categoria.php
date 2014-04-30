<?php

class Categoria extends SON_Db_DomainObjectAbstract {

    protected $_mapper = "CategoriaMapper";
    private $nome = null;
    private $descricao = null;

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getNomeCategorias() {
        return $this->getMapper()->getNomeCategorias();
    }

}

