<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Controllers\Pages\Home;
use \App\Http\Router;
use \App\Http\Response;

define('URL',   'http://localhost/mvc');


$obRouter = new router(URL);


//ROTA HOME
$obRouter->get('/', [
    function () {
        return new Response(200, Home::getHome());
    }
]);

//echo '<pre>';
//print_r($obRouter);
//IMPRIME O RESPONSE DA ROTA
$obRouter->run()->sendResponse();
