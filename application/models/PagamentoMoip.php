<?php

class PagamentoMoip {

    public function generateXML(Cliente $cliente, Carrinho $carrinho, $pedido_id, $frete='Sedex') {
        $xml = new DomDocument('1.0', 'UTF-8');

        $instrucao = $xml->createElement('EnviarInstrucao', '');
        $xml->appendChild($instrucao);

        $unica = $xml->createElement('InstrucaoUnica', '');
        $instrucao->appendChild($unica);

        $razao = $xml->createElement('Razao', 'Compra Online');
        $unica->appendChild($razao);

        $idproprio = $xml->createElement('IdProprio', $pedido_id);
        $unica->appendChild($idproprio);


        // Pagador
        $pagador = $xml->createElement('Pagador', '');
        $unica->appendChild($pagador);

        $nome = $xml->createElement('Nome', $cliente->getNome());
        $pagador->appendChild($nome);

        $email = $xml->createElement('Email', $cliente->getEmail());
        $pagador->appendChild($email);


        // endereco cobranca
        $enderecocobranca = $xml->createElement('EnderecoCobranca', '');
        $pagador->appendChild($enderecocobranca);


        $logradouro = $xml->createElement('Logradouro', $cliente->getRua());
        $enderecocobranca->appendChild($logradouro);

        $numero = $xml->createElement('Numero', $cliente->getNumero());
        $enderecocobranca->appendChild($numero);

        $complemento = $xml->createElement('Complemento', $cliente->getComplemento());
        $enderecocobranca->appendChild($complemento);

        $bairro = $xml->createElement('Bairro', $cliente->getBairro());
        $enderecocobranca->appendChild($bairro);


        $cidade = $xml->createElement('Cidade', $cliente->getCidade());
        $enderecocobranca->appendChild($cidade);

        $estado = $xml->createElement('Estado', $cliente->getEstado());
        $enderecocobranca->appendChild($estado);

        $pais = $xml->createElement('Pais', 'BRA');
        $enderecocobranca->appendChild($pais);


        $cep = $xml->createElement('CEP', $cliente->getCep());
        $enderecocobranca->appendChild($cep);


        $telefonefixo = $xml->createElement('TelefoneFixo', '(' . $cliente->getDdd() . ') ' . $cliente->getTelefone());
        $enderecocobranca->appendChild($telefonefixo);



        $formaspagamento = $xml->createElement('FormasPagamento', '');
        $unica->appendChild($formaspagamento);

        $formpagto = $xml->createElement('FormaPagamento', 'BoletoBancario');
        $formaspagamento->appendChild($formpagto);

        $formpagto = $xml->createElement('FormaPagamento', 'CarteiraMoIP');
        $formaspagamento->appendChild($formpagto);

        $formpagto = $xml->createElement('FormaPagamento', 'CartaoCredito');
        $formaspagamento->appendChild($formpagto);

        $formpagto = $xml->createElement('FormaPagamento', 'DebitoBancario');
        $formaspagamento->appendChild($formpagto);

        $valores = $xml->createElement('Valores', '');
        $unica->appendChild($valores);

        $valor = $xml->createElement('Valor', $carrinho->getTotal());
        $valores->appendChild($valor);

        $mensagens = $xml->createElement('Mensagens', '');
        $unica->appendChild($mensagens);

        $allCarrinho = $carrinho->fetchAll();
        foreach ($allCarrinho as $p) {

            $mensagem = $xml->createElement('Mensagem', $p['qtd'] . ' - ' . $p['produto']->getNome() . ' - ' . Zend_Registry::get('currency')->toCurrency($p['produto']->getValor()));
            $mensagens->appendChild($mensagem);
        }

        $entrega = $xml->createElement('Entrega', '');
        $unica->appendChild($entrega);

        $destino = $xml->createElement('Destino', 'MesmoCobranca');
        $entrega->appendChild($destino);

        // sedex10
        $calculofrete = $xml->createElement('CalculoFrete', '');
        $entrega->appendChild($calculofrete);

        $tipo = $xml->createElement('Tipo', 'Correios');
        $calculofrete->appendChild($tipo);

        $prazo = $xml->createElement('Prazo', '1');
        $calculofrete->appendChild($prazo);

        $prazo_tipo = $xml->createAttribute("Tipo");
        $prazo->appendChild($prazo_tipo);

        $prazo_tipo_value = $xml->createTextNode("Uteis");
        $prazo_tipo->appendChild($prazo_tipo_value);

        $correios = $xml->createElement('Correios', '');
        $calculofrete->appendChild($correios);

        $peso = $xml->createElement('PesoTotal', $carrinho->getTotalPeso());
        $correios->appendChild($peso);

        $forma = $xml->createElement('FormaEntrega', $frete);
        $correios->appendChild($forma);


        return $xml->saveXML();
    }

    public function getToken($token, $key, $xml) {
        $header = "Authorization: Basic " . base64_encode($token . ":" . $key);
        $httpClient = new Zend_Http_Client('https://desenvolvedor.moip.com.br/sandbox/ws/alpha/EnviarInstrucao/Unica');
        $httpClient->setHeaders($header);
        $httpClient->setRawData($xml);
        
        $responseMoIP = $httpClient->request('POST');

        $res = simplexml_load_string($responseMoIP->getBody());

        foreach ($res->children() as $child) {
            foreach ($child as $c) {
                if ($c->getName() == 'Token')
                    $moipToken = $c;

                if ($c->getName() == "Status")
                    $status = $c;
            }
        }

        if ($status == "Sucesso")
            return $moipToken;

        else
            return false;
    }

   
    public function generateUrl($token) {
        $url = "https://desenvolvedor.moip.com.br/sandbox/Instrucao.do?token=" . $token;
        return $url;
    }
}