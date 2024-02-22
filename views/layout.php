<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $titulo; ?> - Centro de Estética LaraBel</title>
        <link href="https://fonts.googleapis.com/css2?family=Agbalumo&family=Poppins:wght@300;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="/build/css/app.css">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon/favicon-96x96.png">
    </head>
    <body>
        <div class="contenedor-app">
            <div class="imagen">
                <h1 class="logo">LaraBel</h1>
                <p class="descripcion-logo">Centro de Estética</p>
            </div>
            <div class="app">
                <?php echo $contenido; ?>
            </div>
        </div>
        <footer class="footer">
            <p class="descripcion-footer">Proyecto DAW 2024 - Joaquín Rodríguez Ladera</p>
            <ul class="lista-redes">
                <li><a href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-square-facebook"></i></a></li>
                <li><a href="https://twitter.com/" target="_blank"><i class="fa-brands fa-square-x-twitter"></i></a></li>
                <li><a href="https://www.instagram.com/" target="_blank"><i class="fa-brands fa-square-instagram"></i></a></li>
            </ul>
        </footer>
        <?php echo $script ?? ''; ?>
    </body>
</html>