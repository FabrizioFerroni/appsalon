<?php

declare(strict_types=1);
// require 'app.php';
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . '/funciones.php');
define('CARPETA_IMG', $_SERVER['DOCUMENT_ROOT'] . '\uploads\\');

function debug($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    die();
}

function s(string $html): string
{
    $s = htmlspecialchars($html);
    return $s;
}

function esUltimo(string $actual, string $proximo): bool
{
    if ($actual !== $proximo) {
        return true;
    } else {
        return false;
    }
}

// Función que revisa que el usuario este logueado
function isAuth(): void
{
    if (!isset($_SESSION['login'])) {
        header('Location: /');
    }
}

function isAdmin(): void{
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}