<h1 class="nombre-pagina">Recuperar mi contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña para poder ingresar al sistema</p>

<!-- <?php
    foreach ($errores as $k => $mensajes) {
        foreach ($mensajes as $mensaje) {
            ?>
            <div class="alerta2 <?php echo $k; ?>">
                <?php echo $mensaje; ?>
            </div>
            <?php
        }
    }
    ?> -->
    <?php 
    include_once __DIR__ .'/../templates/alertas.php';
    if($error) return; 
?>
<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="Ingresa tu contraseña" autocomplete="off"  />
    </div>

    <div class="campo">
        <label for="repassword">Confirmar contraseña:</label>
        <input type="password" id="repassword" name="repassword" placeholder="Confirma tu contraseña" autocomplete="off"  />
    </div>

    <input type="submit" value="Cambiar clave" class="boton">
</form>

<?php 
    $script ="<script src='build/js/error.js'></script>";
?>