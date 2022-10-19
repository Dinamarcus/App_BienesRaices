<main class="contenedor seccion">
        <h1>Registrar Vendedor(a)</h1>

        <a href="/admin" class = "boton boton-verde">Atras</a>

        <?php foreach($errores as $error): ?> <!--Recorre el array por lo menos 1 vez por cada elemento, osea ejecuta el codigo una vez por cada elemento -->
            <div class = "alerta error">
            <?php echo $error; ?> 
            </div>
        <?php endforeach; ?>

        <form class = "formulario" method="POST" action = "/vendedores/crear"> <!--El atributo enctype es NECESARIO para leer archivos.-->
            <?php include 'formulario.php'; ?>
            <input type="submit" value="Registrar Vendedor(a)" class = "boton boton-verde">
        </form>
</main>