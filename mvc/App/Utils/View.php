<?php

namespace App\Utils;

class view
{
    /**
     * Método responsável por retornar o conteúdo da view
     * @param [string] $view
     * @param array $name
     * @return string
     */
    public static function getContentview($view)
    {
        $file = __DIR__ . '/../../resources/View/' . $view . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }


    /**
     * Método responsável por retornar o conteúdo renderizado da view
     */
    public static function render($view, $vars = [])
    {
        //CONTEÚDO DA VIEW
        $contentView = self::getContentview($view);

        //CHAVE DO ARRAY DE VARIÁVEIS
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);


        return str_replace($keys, array_values($vars), $contentView);
    }
}
