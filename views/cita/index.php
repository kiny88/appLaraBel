<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>
<?php
    include_once __DIR__ . '/../templates/barra.php';
?>
<div id="app">
    <nav class="tabs">
        <button class="actual" type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Información Cita</button>
        <button type="button" data-paso="3">Resumen</button>
        <button type="button" data-paso="4">Ver Citas</button>
    </nav>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p class="text-center">Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    <div id="paso-2" class="seccion">
        <h2>Tus Datos y Cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>
        <form action="" class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Tu nombre" value="<?php echo $nombre; ?>" disabled>
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date" name="fecha" id="fecha" min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <select id="hora">
                    <option value="">-- Selecciona --</option>
                </select>
            </div>
            <input type="hidden" id="id" value="<?php echo $id; ?>">
        </form>
    </div>
    <div id="paso-3" class="seccion contenido-resumen">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>
    <div id="paso-4" class="seccion">
        <h2>Citas</h2>
        <p class="text-center">Todas las citas existentes</p>
        <?php
            include_once __DIR__ . '/../templates/alertas.php';
        ?>
        <div id="citas-cliente">
            <ul class="citas">
                <?php
                    $idCita = 0;
                    foreach($citas as $key => $cita){
                        if($idCita !== $cita->id){
                            $total = 0;
                ?>
                    <li>
                        <p>ID: <span><?php echo $cita->id; ?></span></p>
                        <p>Fecha: <span><?php echo date('d/m/Y', strtotime($cita->fecha)); ?></span></p>
                        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
                        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p>
                        <p>Email: <span><?php echo $cita->email; ?></span></p>
                        <p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>
                        <h3>Servicios</h3>
                <?php
                    $idCita = $cita->id; 
                    }

                    $total = $total + $cita->precio;
                ?>
                        <p class="servicio"><?php echo $cita->servicio . ": "; ?><span><?php echo $cita->precio; ?>€</span></p>
                    <!--</li>-->
                <?php
                    $actual = $cita->id;
                    $proximo = $citas[$key + 1]->id ?? 0;

                    if(esUltimo($actual,$proximo)){
                ?>
                    <p class="total">Total: <span><?php echo $total; ?>€</span></p>
                    <form action="/api/eliminar" method="POST">
                        <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                        <input type="button" value="Cancelar Cita" class="boton-eliminar" onclick="confirmCancelarCita(form)">
                    </form>
                <?php 
                        }
                    } 
                ?>
            </ul>
        </div>
    </div>
    <div class="paginacion">
        <button id="anterior" class="boton">&laquo; Anterior</button>
        <button id="siguiente" class="boton">Siguiente &raquo;</button>
    </div>
</div>
<?php
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/app.js'></script>
        <script src='build/js/confirmaciones.js'></script>";
?>