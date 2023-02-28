<div class="barra">
    <p>Hola: <span><?php echo $nombre ?? ''; ?></span></p>
    <a href="/cerrarsesion" class="boton2">Cerrar sesión</a>
</div>

<?php if(isset($_SESSION['admin'])){
?>

  <div class="barra-servicios">
        <a class="boton" href="/admin/turnos">Ver turnos</a>
        <a class="boton" href="/admin/servicios">Servicios</a>
        <a class="boton" href="/admin/servicio/crear">Nuevo servicio</a>
    </div>
<?php
}
?>