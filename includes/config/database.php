<?php

$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];
$basededatos = $_ENV['DB_BD'];

$db = mysqli_connect($host, $user, $pass, $basededatos);




if (!$db) {
    echo "Error: No se pudo conectar a MySQL. <br>";
    echo "Errno de depuracion: " . mysqli_connect_errno();
    echo "<br>Error de depuracion: " . mysqli_connect_error();
    die();
}
