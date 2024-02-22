<?php

namespace Controllers;

use Model\Cita;
use MVC\Router;

class CitaController{
    public static function index(Router $router){
        session_start();
        isAuth();
        
        $router->render('cita/index',[
            'titulo' => 'Crear Nueva Cita',
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    }
}