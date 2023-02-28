<h1 class="nombre-pagina">Ver turnos</h1>
<p class="descripcion-pagina">Verifica todos los turnos solicitados.</p>

<?php
include_once __DIR__ . '/../../templates/barra.php';
?>
<div class="busqueda">
    <h2>Buscar citas</h2>
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" placeholder="Ingresa tu fecha" value="<?php echo $fecha; ?>" autocomplete="off" required />
        </div>
    </form>
</div>
<?php
    if(count($citas) === 0) {
        echo "<h3 class='no-hay'>No hay turnos reservados para esta fecha.</h3>";
    }
?>
<div class="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita) {
            if ($idCita !== $cita->id) {
                $total = 0;
        ?>
                <li>
                    <p>Fecha: <span><?php echo $cita->fecha; ?></span></p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                    <p>Email: <span><?php echo $cita->email; ?></span></p>
                    <p>Telefono: <span><?php echo $cita->telefono; ?></span></p>

                    <h3>Servicios solicitados:</h3>
                <?php
                $idCita = $cita->id;
            } //Fin if cita
            $total += $cita->precio;
                ?>
                <p class="servicio"><?php echo $cita->servicio . ' $' . number_format($cita->precio, 0, ',', '.'); ?></p>
                <?php
                $actual = $cita->id;
                $proximo = $citas[$key + 1]->id ?? 0;

                if (esUltimo($actual, $proximo)) {
                    ?>
                    <p>Total a pagar: <span>$<?php echo number_format($total, 0, ',', '.'); ?></span></p>

                    <form action="/api/turno/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="submit" class="boton-eliminar" value="Eliminar">
                    </form>
                    <?php
                }
                ?>
            <?php
        } // Fin foreach
            ?>
    </ul>
</div>

<?php 
$script = "
<script src='/build/js/buscador.js'></script>
<script src='/build/js/nav.js'></script>
";
?>