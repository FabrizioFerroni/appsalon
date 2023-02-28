<?php

namespace MVC;

class Router
{



    public $rutasGET = [];
    public $rutasPOST = [];

    public function get($url, $fn, $id = null)
    {
        $this->rutasGET[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas()
    {
        $urlActual = $_SERVER['REQUEST_URI'] === '' ?  '/' : $_SERVER['REQUEST_URI'];
        $metodo = $_SERVER['REQUEST_METHOD'];
        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        if ($fn) {
            // La url existe y si tiene una funcion asociada.
            call_user_func($fn, $this);
        } else {
            echo "Pagina no encontrada o ruta no válida";
        }
    }

    public function render($view, $datos = [], $titulo = "App Salón")
    {
        foreach ($datos as $k => $v) {
            $$k = $v;
        }

        ob_start();
        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();

        include __DIR__ . "/views/layout.php";
    }
}
