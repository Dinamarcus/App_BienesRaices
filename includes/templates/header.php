<?php
    if (!isset($_SESSION)) {
        session_start(); //PARA ACCEDER A LA SUPERGLOBAL SESSION ES NECESARIO UTILIZAR ESTA FUNCION
    }
    $auth = $_SESSION['login'] ?? false;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css"> <!--para que cargue el css, la primer barra es para indicar que en la raiz esta esa carpeta-->
    <script src="https://kit.fontawesome.com/7535d2a0b0.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <header class="header <?php echo ($inicio) ? 'inicio' : ''; ?>"> <!--El codigo de adentro es el que se encarga de verificar si la variable $inicio es igual a true y ademas esta definida, por lo que si se cumple esto agrega la clase a header -->
        <div class="contenedor contenido-header">
        <div class="barra">
            <a href="index.html">
            <img src="build/img/logo.svg" alt="Logo sitio">
            </a>

            <div class = "mobile-menu" id="mobile-menu" onclick="myFunction(this)">
                <div class="linea-1"></div>
                <div class="linea-2"></div>
                <div class="linea-3"></div>
            </div>
            
            <div class = "derecha">
                <img src = "build/img/dark-mode.svg" class = "dark-mode-boton" alt = "boton darkmode">
            <nav class="navegacion">
                <a href="nosotros.html">Nosotros</a>
                <a href="anuncios.html">Anuncios</a>
                <a href="blog.html">Blog</a>
                <a href="contacto.html">Contacto</a>
            </nav>
            </div>
        </div> <!--Barra-->

            <?php 
                if ($inicio) {
                    echo "<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>";
                }
            ?>
        </div>
    </header>