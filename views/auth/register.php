<h1 class="nombre-pagina">Crear cuenta nueva</h1>
<p class="descripcion-pagina">Llena el siguiente el formulario para crear una cuenta</p>

<?php 
    include_once __DIR__ .'/../templates/alertas.php';
?>

<form action="/registrarse" method="POST" class="formulario">
    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="Ingresa tu nombre" autocomplete="off" value="<?php echo s($usuario->nombre); ?>" required />
    </div>
    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="Ingresa tu apellido" autocomplete="off" value="<?php echo s($usuario->apellido); ?>" required />
    </div>
    <div class="campo">
        <label for="telefono">Telefono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="Ingresa tu telefono" autocomplete="off" value="<?php echo s($usuario->telefono); ?>" required />
    </div>
    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Ingresa tu email" autocomplete="off"  value="<?php echo s($usuario->email); ?>" required />
    </div>

    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" autocomplete="off" required />
    </div>

        <input type="submit" value="Crear cuenta" class="boton">
</form>

<div class="acciones">
    <span>¿Ya tenes cuenta? <a href="/">Inicia Sesion</a></span>
</div>

<?php 
    $script ="<script src='build/js/error.js'></script>";
?>