<h1 class="nombre-pagina">Confirmación de cuenta</h1>

<?php
    foreach ($errores as $k => $mensajes) {
        foreach ($mensajes as $mensaje) {
            ?>
            <div class="alerta2 <?php echo $k; ?>">
                <?php echo $mensaje; ?>
            </div>
            <?php
        }
    }
?>

<div class="login-flex">
    <a href="/" class="boton">Iniciar Sesión</a>
</div>

<?php 
    $script ="<script src='build/js/error.js'></script>";
?>