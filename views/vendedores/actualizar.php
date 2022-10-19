<main class="contenedor seccion">
        <h1>Actualizar vendedor(a)</h1>

        <a href="/admin" class = "boton boton-verde">Atras</a>

        <?php foreach($errores as $error): ?> <!--Recorre el array por lo menos 1 vez por cada elemento, osea ejecuta el codigo una vez por cada elemento -->
            <div class = "alerta error">
            <?php echo $error; ?> 
            </div>
        <?php endforeach; ?>

        <form class = "formulario" method="POST"> <!--El atributo accion en este caso es eliminado para que lo mande a la misma url ya que tenemos un id arriba-->
            <?php include 'formulario.php'; ?>
            <input type="submit" value="Guardar Cambios" class = "boton boton-verde">
        </form>
    </main>
