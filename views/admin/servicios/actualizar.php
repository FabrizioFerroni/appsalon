<h1 class="nombre-pagina">Actualizar servicio</h1>
<p class="descripcion-pagina">Editar un servicio existente.</p>

<?php
include_once __DIR__ . '/../../templates/barra.php';
include_once __DIR__ . '/../../templates/alertas.php';
?>

<form class="formulario" method="POST">
    <?php include_once 'formulario.php';?>

    <input type="submit" class="boton" value="Editar servicio">
</form>

<?php
$script = "
<script src='/build/js/nav.js'></script>
<script src='/build/js/error.js'></script>
";
?>