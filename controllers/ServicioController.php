<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController{
    public static function index(Router $router){
        session_start();
        isAdmin();
        $alertas = [];

        $servicios = Servicio::all();

        if(empty($servicios)){
            $alertas = Servicio::setAlerta('error','No hay servicios disponibles');
        }

        $alertas = Servicio::getAlertas();

        $router->render('servicios/index',[
            'titulo' => 'servicios',
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios,
            'alertas' => $alertas
        ]);
    }

    public static function crear(Router $router){
        session_start();
        isAdmin();

        $servicio = new Servicio;
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                $alertas = Servicio::setAlerta('exito','Servicio creado correctamente');
                header('refresh: 2; url=/servicios');
            }
        }

        $alertas = Servicio::getAlertas();

        $router->render('servicios/crear',[
            'titulo' => 'Nuevo Servicio',
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function actualizar(Router $router){
        session_start();
        isAdmin();

        if(!is_numeric($_GET['id'])){
            return;
        }

        $servicio = Servicio::find($_GET['id']);
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if(empty($alertas)){
                $servicio->guardar();
                $alertas = Servicio::setAlerta('exito','Servicio actualizado correctamente');
                header('refresh: 2; url=/servicios');
            }
        }

        $alertas = Servicio::getAlertas();

        $router->render('servicios/actualizar',[
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    }

    public static function eliminar(){
        session_start();
        isAdmin();
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $id = $_POST['id'];
            $servicio = Servicio::find($id);
            $servicio->eliminar();
            
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}