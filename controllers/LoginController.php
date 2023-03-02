<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function Login(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // Comprobar que exista el usuario
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {
                    // Verificar el password
                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {
                        // Autenticar el usuario
                        session_start();
                       

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionamiento
                        if ($usuario->admin === "1") {
                            $_SESSION['admin'] = $usuario->admin ?? null;
                            header('Location: /admin');
                        } else {
                            header('Location: /reservar-turno');
                        }
                    }
                } else {
                    Usuario::setAlerta('error', 'Usuario y/o contraseña incorrecta, por favor vuelva a intentarlo');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        

        $router->render('auth/login', [
            'alertas' => $alertas
        ], 'Iniciar sesión - App Salón');
    }

    public static function Logout()
    {
        session_start();
        session_destroy();
        header("Location:/");
    }

    public static function Olvide(Router $router)
    {
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();
            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);
                if ($usuario && $usuario->confirmado == 1) {
                    // Generar un token de un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();


                    $url = $_SERVER['HTTP_ORIGIN'];
                    $email = new Email($usuario->nombre, $usuario->apellido, $usuario->email, $usuario->token, $url);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones de cambio de clave al email');
                } else {
                    Usuario::setAlerta('error', 'El usuario que ingresaste no se encuentra o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/olvide', [
            'alertas' => $alertas
        ], 'Olvide contraseña - App Salón');
    }

    public static function Recuperar(Router $router)
    {
        $alertas = [];

        $token = s($_GET['token']);
        $error = false;

        $usuario = Usuario::where('token', $token);
        if (empty($usuario)) {
            Usuario::setAlerta('error', 'El token que ingresaste no es valido');
            $error = true;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if ($_POST['password'] !== $_POST['repassword']) {
                Usuario::setAlerta('error', 'Las contraseñas no coinciden, ingresa contraseñas iguales');
            }

            $password = new Usuario($_POST);

            $alertas = $password->validarPassword();

            if(empty($alertas)){
                $usuario->password = null;

                $usuario->password = $password->password;
                
                $usuario->hashPassword();
                
                $usuario->token = null;

                $resultado = $usuario->guardar();

                if($resultado){
                    header('Location:/');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/recuperar', [
            'alertas' => $alertas,
            'error' => $error
        ], 'Recuperar contraseña - App Salón');
    }

    public static function Registrarse(Router $router)
    {
        $usuario = new Usuario;
        $alertas = Usuario::getAlertas();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if (empty($alertas)) {
                // Verificar si el usuario no esta registrado
                $resultado = $usuario->existeUsuario();

                if ($resultado->num_rows) {
                    $alertas = Usuario::getAlertas();
                } else {

                    // No esta registrado
                    // Hashear contraseña
                    $usuario->hashPassword();

                    // Generar token unico
                    $usuario->crearToken();

                    $url = $_SERVER['HTTP_ORIGIN'];

                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->apellido, $usuario->email, $usuario->token, $url);
                    $email->enviarConfirmacion();


                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    }
                }
            }
            // debug($alertas);
        }
        $router->render('auth/register', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ], 'Crear nueva cuenta - App Salón');
    }
    public static function Confirmar(Router $router)
    {
        $errores = [];
        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no valido');
        } else {
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Se ha confirmado con éxito tu cuenta');
        }

        $errores = Usuario::getAlertas();

        $router->render('auth/confirma', [
            'errores' => $errores
        ], 'Gracias por registrarte, cuenta confirmada con éxito - App Salón');
    }

    public static function Mensaje(Router $router)
    {
        $router->render('auth/mensaje', [], 'Confirma tu cuenta - App Salón');
    }
}