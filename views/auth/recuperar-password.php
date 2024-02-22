<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Coloca tu nueva contraseña a continuación</p>
<?php
    include_once __DIR__ . "/../templates/alertas.php";
?>
<?php if($error) return; ?>
<form method="POST" class="formulario">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password" name="password" id="password" placeholder="Tu nueva Contraseña">
    </div>
    <input type="submit" value="Guardar Nueva Contraseña" class="boton">
</form>
<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a>
    <a href="/crear-cuenta">¿Aún no tienes cuenta? Obtener una</a>
</div>