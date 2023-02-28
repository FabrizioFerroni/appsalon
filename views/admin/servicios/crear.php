<h1 class="nombre-pagina">Crear servicio</h1>
<p class="descripcion-pagina">Añadir nuevo servicio.</p>

<?php
include_once __DIR__ . '/../../templates/barra.php';
include_once __DIR__ . '/../../templates/alertas.php';
?>

<form action="/admin/servicio/crear" class="formulario" method="POST">
    <?php include_once 'formulario.php';?>

    <input type="submit" class="boton" value="Crear servicio">
</form>

<?php
$script = "
<script src='/build/js/nav.js'></script>
<script src='/build/js/error.js'></script>
";
?>