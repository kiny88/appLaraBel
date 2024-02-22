<h1 class="nombre-pagina">ERROR 404!!!</h1>
<p class="descripcion-pagina"><?php echo $titulo; ?>. Tal vez quieras volver al inicio</p>
<?php if(isset($_SESSION['admin'])){ ?>
    <div class="acciones">
        <a href="/admin">Ir al Inicio</a>
    </div>
<?php }else{ ?>
    <div class="acciones">
        <a href="/cita">Ir al Inicio</a>
    </div>
<?php } ?>