<?php

namespace App\Http;

use \Closure;
use Exception;
use \App\Http\Response;

class router
{
    /**
     * URL completa do projeto
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Indice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instância de request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request = new request();
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Método responsável por definir o prefixo das rotas
     */
    private function setPrefix()
    {
        //INFORMAÇÕES DA URL ATUAL
        $ParselUrl = parse_url($this->url);

        //DEFINE O PREFIXO
        $this->prefix = $ParselUrl['path'] ?? '';
    }


    /**
     * Método responsável por adicionar uma rota na classe
     */
    private function addRoute($method, $route, $params = [])
    {
        //VALIDAÇÃO DOS PARÂMETROS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        //PARÃO DE VALIDAÇÃO DA URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }
    //METODOS HTTP
    //===========================================================================
    /**
     * Método responsável por definir uma rota de GET
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    //===========================================================================

    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     */
    private function getUri()
    {
        //URI DA REQUEST
        $uri = $this->request->getUri();

        //FATIA A URI COM O PREFIXO
        $Xuri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        //RETORNA A URI SEM PREFIXO
        return end($Xuri);
    }


    /**
     *Método responsável por retornar o dados da rota atual
     */
    private function getRoute()
    {
        //URI
        $uri = $this->getUri();

        //METHOD
        $HttpMethod = $this->request->getHttpMethod();

        //VALIDA AS ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE A URI BATE COM O PADRÃO
            if (preg_match($patternRoute, $uri)) {
                //VERIFICA O MÉTODO
                if (isset($methods[$HttpMethod])) {

                    //RETORNO DOS PARÃMETROS DA ROTA
                    return $methods[$HttpMethod];
                }
                //MÉTODO NÃO PERMITIDO/DEFINIDO
                throw new Exception("Método não permitido", 405);
            }
        }
        //URL NÃO ENCONTRADA
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * Método responsável por executar a rota atual
     */
    public function run()
    {
        try {
            $route = $this->getRoute();
            return new Response(200, $route);

            //VERIFICA O CONTROLADOR
            if (!isset($route['controller'])) {
                throw new Exception("A URL não pode ser processada", 500);
            }
            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //RETORNA A EXECUÇÃO DA FUNÇÃO
            call_user_func_array($route['controller'], $args);
        } catch (Exception $e) {
            return new response($e->getCode(), $e->getMessage());
        }
    }
}

//192.168.1.159
