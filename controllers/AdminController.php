<?php

namespace Controllers;

use Model\AdminCita;
use MVC\Router;

class AdminController
{
    public static function Index(Router $router){
        session_start();

        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
        ], 'Panel de administración - App Salón');
    }
    public static function IndexTurnos(Router $router)
    {
        $alertas = [];
        session_start();
        isAdmin();

        $fecha = $_GET['fecha'] ?? date('Y-m-d');
        $fechas = explode('-', $fecha);

        if( !checkdate( $fechas[1], $fechas[2], $fechas[0]) ) {
            header('Location: /404');
        }
        
        $consulta = "SELECT c.id, c.fecha, c.hora, CONCAT(u.nombre, ' ', u.apellido) AS cliente, ";
        $consulta .= " u.email, u.telefono, s.nombre AS servicio, s.precio ";
        $consulta .= " FROM citas AS c ";
        $consulta .= " LEFT OUTER JOIN usuarios AS u ";
        $consulta .= " ON c.usuarioId = u.id  ";
        $consulta .= " LEFT OUTER JOIN citasservicios AS cs";
        $consulta .= " ON cs.citaId = c.id ";
        $consulta .= " LEFT OUTER JOIN servicios AS s ";
        $consulta .= " ON s.id = cs.servicioId ";
        $consulta .= " WHERE fecha =  '${fecha}' ";

        $citas = AdminCita::SQL($consulta);

        $router->render('admin/turnos/index', [
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ], 'Ver turnos - App Salón');
    }
}
