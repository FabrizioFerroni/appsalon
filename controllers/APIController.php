<?php

namespace Controllers;

use Classes\Email;
use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use Model\Usuario;
use MVC\Router;

class APIController
{
    public static function Index(Router $router)
    {
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function Guardar()
    {
        try {
            // Almacena la cita y devuelve el ID
            $cita = new Cita($_POST);
            $resultado = $cita->guardar();
            $id = $resultado['id'];

            //  Almacena la cita y los servicios
            $idServicios = explode(',', $_POST['servicios']);

            foreach ($idServicios as $idServicio) {
                $args = [
                    'citaId' => $id,
                    'servicioId' => $idServicio
                ];
                $citaServicio = new CitaServicio($args);
                $citaServicio->guardar();
            }

            // Retornamos una respuesta
            $respuesta = [
                'resultado' => $resultado
            ];
        } catch (\Throwable $th) {
            $respuesta = $th;
        }

        echo json_encode($respuesta);
    }

    public static function Eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $cita = Cita::find($id);
            $cita->Eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }
}
