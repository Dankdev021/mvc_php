<?php

namespace App\Controllers\Pages;

use \App\Utils\View;

class page
{

    /**
     * Método responsável por renderizar o topo da página
     */
    private static function getHeader()
    {
        return View::render('pages/header');
    }

    /**
     * Método responsável por renderizar o footer da página
     */
    private static function getFooter()
    {
        return View::render('pages/footer');
    }



    /**
     * Método responsável por retornar o conteúdo (view) da nossa página genérica
     * @return string
     */
    public static function getPage($title, $content)
    {
        return view::render('pages/page', [
            "title" => $title,
            "header" => self::getHeader(),
            "content" => $content,
            "footer" => self::getFooter()
        ]);
    }
}
