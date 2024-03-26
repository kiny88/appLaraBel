<h1 class="nombre-pagina">Servicios</h1>
<p class="descripcion-pagina">Administración de Servicios</p>
<?php
    include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>
<ul class="servicios">
    <?php foreach($servicios as $servicio){ ?>
        <li>
            <p>Nombre: <span><?php echo $servicio->nombre; ?></span></p>
            <p>Precio: <span><?php echo $servicio->precio; ?>€</span></p>
            <div class="acciones-servicios">
                <a href="/servicios/actualizar?id=<?php echo $servicio->id; ?>" class="boton-actualizar">Actualizar</a>
                <form action="/servicios/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $servicio->id; ?>">
                    <input type="button" value="Borrar" class="boton-eliminar" onclick="confirmEliminarServicio(form)">
                </form>
            </div>
        </li>
    <?php } ?>
</ul>
<?php
    $script = "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script src='build/js/confirmaciones.js'></script>";
?>