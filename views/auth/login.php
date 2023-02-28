<h1 class="nombre-pagina">Iniciar Sesión</h1>
<p class="descripcion-pagina">Inicia sesión con tus datos</p>

<?php 
    include_once __DIR__ .'/../templates/alertas.php';
?>

<form action="/" method="POST" class="formulario">
    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email" required/>
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required />
    </div>

    <input type="submit" value="Iniciar sesión" class="boton">
</form>

<div class="acciones">
    <span>¿Aún no tenes cuenta? <a href="/registrarse">Crear una</a></span>
    <span>¿Te olvidaste la contraseña? <a href="/olvide-clave">Recuperar clave</a></span>
</div>

<?php 
    $script ="<script src='build/js/error.js'></script>";
?>