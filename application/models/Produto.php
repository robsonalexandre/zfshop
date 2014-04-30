<?php

class Produto extends SON_Db_DomainObjectAbstract {

    protected $_mapper = "ProdutoMapper";
    private $nome = null;
    private $descricao = null;
    private $valor = null;
    private $valor_promocao = null;
    private $peso = null;
    private $estoque = null;
    private $categoria_id = null;

    public function get_mapper() {
        return $this->_mapper;
    }

    public function set_mapper($_mapper) {
        $this->_mapper = $_mapper;
    }

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

    public function getValor() {
        return $this->valor;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function getValor_promocao() {
        return $this->valor_promocao;
    }

    public function setValor_promocao($valor_promocao) {
        $this->valor_promocao = $valor_promocao;
    }

    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }

    public function getEstoque() {
        return $this->estoque;
    }

    public function setEstoque($estoque) {
        $this->estoque = $estoque;
    }

    public function getCategoria_id() {
        return $this->categoria_id;
    }

    public function setCategoria_id($categoria_id) {
        $this->categoria_id = $categoria_id;
    }

    public function getByCategoriaId($id) {
        return $this->getMapper()->getByCategoriaId($id);
    }

    public function delete($id) {
        @unlink("images/produtos/".$id.".jpg");
        return $this->getMapper()->delete($id);
    }

    public function hasImage() {
        $path = "images/produtos/".$this->getId().".jpg";
        if(file_exists($path))
            return true;
    }
}


