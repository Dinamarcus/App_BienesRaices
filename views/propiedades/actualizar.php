<main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        <?php foreach($errores as $error): ?> <!--Recorre el array por lo menos 1 vez por cada elemento, osea ejecuta el codigo una vez por cada elemento -->
            <div class = "alerta error">
            <?php echo $error; ?> 
            </div>
        <?php endforeach; ?>

        <a href = "/admin" class = "boton boton-verde">Atras</a>

        <form class = "formulario" method = "POST" enctype="multipart/form-data">
        <?php include 'formulario.php'; ?>
        
        <input type = "submit" value = "Actualizar Propiedades" class = "boton boton-verde">
        </form>
</main>