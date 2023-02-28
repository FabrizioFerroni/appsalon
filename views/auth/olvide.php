<h1 class="nombre-pagina">Olvide mi contraseña</h1>
<p class="descripcion-pagina">Reestablece tu contraseña escribiendo tu email a continuación</p>

<?php 
    include_once __DIR__ .'/../templates/alertas.php';
?>

<form action="/olvide-clave" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email" autocomplete="off"  />
    </div>

    <input type="submit" value="Recuperar clave" class="boton">
</form>

<div class="acciones">
    <span>¿Ya te acordaste la contraseña? <a href="/">Inicia Sesion</a></span>
</div>

<?php 
    $script ="<script src='build/js/error.js'></script>";
?>