<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class TurnosController
{
    public static function Index(Router $router){
        $alertas = [];
        session_start();

        isAuth();
        date_default_timezone_set('America/Argentina/Cordoba');

        $router->render('turnos/index', [
            'alertas' => $alertas,
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id'],
        ], 'Reservar turno - App Salón');
    }
}