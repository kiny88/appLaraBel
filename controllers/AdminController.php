<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController{
    public static function index(Router $router){
        session_start();
        $alertas = [];
        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-',$fecha);

        if(!checkdate($fechas[1],$fechas[2],$fechas[0])){
            header('Location: /404');
        }

        // Consultar la base de datos
        $consulta = "SELECT citas.id, CONCAT( usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio, ";
        $consulta .= " horas.hora AS hora ";
        $consulta .= " FROM citas  ";
        $consulta .= " LEFT OUTER JOIN horas ";
        $consulta .= " ON horas.id=citas.horaId ";
        $consulta .= " LEFT OUTER JOIN usuarios ";
        $consulta .= " ON citas.usuarioId=usuarios.id  ";
        $consulta .= " LEFT OUTER JOIN citasServicios ";
        $consulta .= " ON citasServicios.citaId=citas.id ";
        $consulta .= " LEFT OUTER JOIN servicios ";
        $consulta .= " ON servicios.id=citasServicios.servicioId ";
        $consulta .= " WHERE fecha =  '{$fecha}' ";

        $citas = AdminCita::SQL($consulta);

        if(empty($citas)){
            AdminCita::setAlerta('error','No hay citas en esta fecha');
        }

        $alertas = AdminCita::getAlertas();

        $router->render('admin/index',[
            'titulo' => 'Panel de Administración',
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha,
            'alertas' => $alertas
        ]);
    }
}