<?php

namespace App\Http;

class request
{
    /**
     * Método http da requisição
     */
    private $HttpMethod;

    /**
     * URI da página
     */
    private $uri;

    /**
     * Parâmetros da url ($_GET)
     */
    private $queryParams = [];

    /**
     * Variáveis recebidos no post da página ($_POST)
     */
    private $postVars = [];

    /**
     * Cabeçalhos da requisição
     */
    private $headers = [];

    /**
     * Contrutor da classe
     */
    public function __construct()
    {
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->HttpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    }

    /**
     * Método responsável por retornar o método Http da requisição
     */
    public function getHttpMethod()
    {
        return $this->HttpMethod;
    }

    /**
     * Método responsável por retornar a URI da requisição
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Método responsável por retornar os headers da requisição
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Método responsável por retornar os parametros da url da requisição
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Método responsável por retornar o método Http da requisição
     */
    public function getPostVars()
    {
        return $this->postVars;
    }
}
