<?php

namespace Controllers;

use MVC\Router;
use Model\AdminCita;

class CitaController{
    public static function index(Router $router){
        session_start();
        isAuth();
        $alertas = [];

        // Consultar la base de datos
        $consulta = "SELECT citas.id, CONCAT( usuarios.nombre, ' ', usuarios.apellido) AS cliente, ";
        $consulta .= " usuarios.email, usuarios.telefono, servicios.nombre AS servicio, servicios.precio, ";
        $consulta .= " citas.fecha AS fecha, ";
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
        $consulta .= " WHERE usuarios.id =  '{$_SESSION['id']}' ";

        $citas = AdminCita::SQL($consulta);

        if(empty($citas)){
            AdminCita::setAlerta('error','No hay citas');
        }

        $alertas = AdminCita::getAlertas();

        $router->render('cita/index',[
            'titulo' => 'Crear Nueva Cita',
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
            'citas' => $citas,
            'alertas' => $alertas
        ]);
    }
}