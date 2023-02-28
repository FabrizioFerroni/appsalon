<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\ServicioController;
use Controllers\AdminController;
use Controllers\APIController;
use MVC\Router;
use Controllers\LoginController;
use Controllers\TurnosController;

$router = new Router();

// Iniciar Sesion
$router->get('/',[LoginController::class, 'Login']);
$router->post('/',[LoginController::class, 'Login']);
$router->get('/cerrarsesion',[LoginController::class, 'Logout']);

// Recuperar password
$router->get('/olvide-clave',[LoginController::class, 'Olvide']);
$router->post('/olvide-clave',[LoginController::class, 'Olvide']);
$router->get('/recuperar-clave',[LoginController::class, 'Recuperar']);
$router->post('/recuperar-clave',[LoginController::class, 'Recuperar']);

// Crear cuenta
$router->get('/registrarse',[LoginController::class, 'Registrarse']);
$router->post('/registrarse',[LoginController::class, 'Registrarse']);
$router->get('/confirmar-cuenta',[LoginController::class, 'Confirmar']);
$router->post('/confirmar-cuenta',[LoginController::class, 'Confirmar']);
$router->get('/mensaje',[LoginController::class, 'Mensaje']);

// Area privada
$router->get('/reservar-turno',[TurnosController::class, 'Index']);
$router->get('/admin',[AdminController::class, 'Index']);
$router->get('/admin/turnos',[AdminController::class, 'IndexTurnos']);
$router->get('/admin/servicios',[ServicioController::class, 'Index']);
$router->get('/admin/servicio/crear',[ServicioController::class, 'Crear']);
$router->post('/admin/servicio/crear',[ServicioController::class, 'Crear']);
$router->get('/admin/servicio/actualizar',[ServicioController::class, 'Actualizar']);
$router->post('/admin/servicio/actualizar',[ServicioController::class, 'Actualizar']);
$router->post('/admin/servicio/eliminar',[ServicioController::class, 'Eliminar']);


// APIS
$router->get('/api/servicios', [APIController::class, 'Index']);
$router->post('/api/turnos', [APIController::class, 'Guardar']);
$router->post('/api/turno/eliminar', [APIController::class, 'Eliminar']);




$router->comprobarRutas();
