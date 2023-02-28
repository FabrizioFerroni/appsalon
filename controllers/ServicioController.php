<?php

namespace Controllers;

use Model\Servicio;
use MVC\Router;

class ServicioController
{
    public static function Index(Router $router)
    {
        session_start();
        isAdmin();
       
        $servicios = Servicio::all();

        $router->render('admin/servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ], 'Servicios - App Salón');
    }

    public static function Crear(Router $router)
    {
        session_start();
        isAdmin();

        $alertas = [];
        $servicio = new Servicio;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location:/admin/servicios');
            }
        }

        $router->render('admin/servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ], 'Crear servicio - App Salón');
    }

    public static function Actualizar(Router $router)
    {
        session_start();
        isAdmin();
        
        $alertas = [];
        $id = $_GET['id'];
        if (!is_numeric($_GET['id'])) header('Location:/admin/servicios');
        $servicio = Servicio::find($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);

            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location:/admin/servicios');
            }
        }

        $router->render('admin/servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ], 'Actualizar servicio - App Salón');
    }

    public static function Eliminar()
    {
        session_start();
        isAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            if (!is_numeric($_POST['id'])) header('Location:/admin/servicios');
            $servicio = Servicio::find($id);
            $servicio->Eliminar();
            header('Location:/admin/servicios');
        }
    }
}
