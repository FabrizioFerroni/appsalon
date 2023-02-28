<div class="campo">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" placeholder="Ingresa el nombre del servicio" autocomplete="off" required value="<?php echo s($servicio->nombre); ?>" />
            </div>

            <div class="campo">
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Ingresa el precio del servicio" min="0" autocomplete="off" required value="<?php echo s($servicio->precio); ?>" />
            </div>