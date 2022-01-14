<?php

namespace App\Controllers\Pages;

use \App\Utils\View;
use \App\Model\Entity\organization;

class home extends page
{
    public static function getHome()
    {
        $organization = new organization();
        //VIEW DA HOME
        $content = view::render('pages/home', [
            "name" => $organization->name,
            "description" => $organization->description,
            "site" => $organization->site
        ]);

        //RETORNA A VIEW DA PÁGINA
        return parent::getPage('AppStore - Dev - Home', $content);
    }
}
