<?php
    if (!isset($_SESSION)) {
        session_start(); //PARA ACCEDER A LA SUPERGLOBAL SESSION ES NECESARIO UTILIZAR ESTA FUNCION
    }
    $auth = $_SESSION['login'] ?? false;
    
    if (!isset($inicio)) {
        $inicio = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css"> <!--para que cargue el css, la primer barra es para indicar que en la raiz esta esa carpeta-->
    <script src="https://kit.fontawesome.com/7535d2a0b0.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>"> <!--El codigo de adentro es el que se encarga de verificar si la variable $inicio es igual a true y ademas esta definida, por lo que si se cumple esto agrega la clase a header -->
        <div class="contenedor contenido-header">
        <div class="barra">
            <a href="/">
            <img src="/build/img/logo.svg" alt="Logo sitio">
            </a>

            <div class = "mobile-menu" id="mobile-menu" onclick="myFunction(this)">
                <div class="linea-1"></div>
                <div class="linea-2"></div>
                <div class="linea-3"></div>
            </div>
            
            <div class = "derecha">
                <img src = "/build/img/dark-mode.svg" class = "dark-mode-boton" alt = "boton darkmode">
            <nav class="navegacion">
                <a href="/nosotros">Nosotros</a>
                <a href="/propiedades">Anuncios</a>
                <a href="/blog">Blog</a>
                <a href="/contacto">Contacto</a>
                <?php if ($auth) { ?>
                    <a href = "/logout">Cerrar Sesion</a>
                <?php } ?>
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
    
    <?php echo $contenido; ?> <!--Se va a insertar lo que este en memoria, lo que la variable contenido dentro de render tenga se inyectara aqui-->

    <footer class="footer">
    <div class="contenedor contenedor-footer"> 
    <nav class = "navegacion mostrar2">
        <a href="nosotros.php">Nosotros</a>
        <a href="anuncios.php">Anuncios</a>
        <a href="blog.php">Blog</a>
        <a href="contacto.php">Contacto</a>
    </nav>
        <div class="apart">
            <div class="iconos">
            <a class="footer__icon" href="https://www.linkedin.com" aria-label="Linkedin" target="_blank" style="color: violet;"><i class="fab fa-linkedin fa-2x"></i></a>
            <a class="footer__icon" href="https://www.instagram.com"  aria-label="Instagram" target="_blank"><i class="fab fa-instagram fa-2x" style="color: violet;"></i></a>
            <a class="footer__icon" href="https://www.facebook.com"  aria-label="Facebook" target="_blank"><i class="fab fa-facebook fa-2x" style="color: violet;"></i></a>
            <a class="footer__icon" href="https://www.twitter.com" aria-label="Twitter" target="_blank"><i class="fab fa-twitter-square fa-2x" style="color: violet;"></i></a>
            </div>
            <small class="footer__text">Copyright&copy; Todos los derechos reservados al autor <?php echo date('Y'); ?>.</small>
        </div>
    </div>
</footer>
<!--FOOTER-->

    <script src="../build/js/bundle.min.js"></script>
</body>
</html>