<?php

namespace App\Http;

class response
{
    /**
     * Código do status http
     */
    private $HttpCode = 200;

    /**
     * Cabeçalho do response
     */
    private $headers = [];

    /**
     * Tipo de conteúdo que será retornado
     */
    private $contentType = 'text/html';

    /**
     * Conteúdo do response
     */
    private $content = 'dd';

    /**
     * Método responsável por iniciar a classe iniciando os valores
     * Construtor da classe
     */
    public function __construct($HttpCode, $content, $contentType = 'text/html')
    {
        $this->HttpCode = $HttpCode;
        $this->content = $content;
        $this->contentType = $contentType;
        $this->setcontentType($contentType);
    }

    /**
     * Método responsável por alterar o content Type do response
     */
    public function setcontentType($contentType)
    {
        $this->contentType = $contentType;
        $this->addHeader('Content-Type', $contentType);
    }

    /**
     * Método responsável por adiccionar um registro no cabeçalho de response
     */
    public function addHeader($key, $value)
    {
        $this->headers[$key] = $value;
    }

    /**
     * Método responsável por enviar os headers para o navegador
     */
    private function sendHeaders()
    {
        //STATUS
        http_response_code($this->HttpCode);

        //ENVIA OS HEADERS
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }
    }
    /**
     * Método responsável por enviar aa responsta para o usuári
     */
    public function sendResponse()
    {
        //ENVIA OS HEADERS
        $this->sendHeaders();

        //IMPRIME O CONTEÚDO
        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                exit;
        }
    }
}
