<?php

namespace Controllers;

use MVC\Router;

class PaginaController{
    public static function error(Router $router){
        session_start();
        isAuth();

        $router->render('pagina/error',[
            'titulo' => 'Página no disponible'
        ]);
    }
}