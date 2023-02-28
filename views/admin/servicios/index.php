<h1 class="nombre-pagina">Ver servicios</h1>
<p class="descripcion-pagina">Ver, actualizar y quitar los servicios ofrecidos.</p>

<?php
include_once __DIR__ . '/../../templates/barra.php';
?>


<ul class="servicios">
    <?php foreach($servicios as $servicio){ ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span>$<?php echo number_format($servicio->precio, 2, ',', '.'); ?></span></p>
            <div class="acciones">
                <a class="boton" href="/admin/servicio/actualizar?id=<?php echo $servicio->id; ?>">Actualizar</a>
                <form action="/admin/servicio/eliminar" method="POST">
                    <input type="hidden" name="id" id="id" value="<?php echo $servicio->id; ?>">
                    <input type="submit" value="Borrar" class="boton-eliminar">
                </form>
            </div>
        </li>

    <?php } ?> 
</ul>












<?php 
$script = "
<script src='/build/js/nav.js'></script>
";
?>