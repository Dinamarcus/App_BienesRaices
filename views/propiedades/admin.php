    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <!--ACA SE EVALUAN LOS QUERYSTRING. DEPENDIENDO LA ACCION QUE HAGAMOS DARA UN RESULTADO Y ESE RESULTADO ESTA ASOCIADO A UNA ALERTA. -->
        <?php 
            if ($resultado) {
                $mensaje = mostrarNotificacion(intval($resultado));
                if ($mensaje) { ?>
                    <p class = "alerta exito"> <?php echo s($mensaje); ?> </p>
                <?php } 
            } 
        ?>

        <a href = "/propiedades/crear" class = "boton boton-verde">Nueva propiedad</a>
        <a href = "/vendedores/crear" class = "boton boton-amarillo">Nuevo Vendedor</a>

        <h2>Propiedades</h2>

        <table class = "propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th >Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- MOSTRAR RESULTADOS-->
                <?php foreach($propiedades as $propiedad): ?>
                <tr>
                    <td><?php echo $propiedad->id;?></td>
                    <td><?php echo $propiedad->titulo;?></td>
                    <td> <img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"> </td>
                    <td><?php echo $propiedad->precio;?></td>
                    <td>
                        <form method="POST" class = "w-100" action = /propiedades/eliminar>
                            <input type="hidden" name="id" value="<?php echo $propiedad->id; ?>" > <!--Permite enviar datos de forma oculta-->
                            <input type="hidden" name="tipo" value="propiedad" >
                            <input class = "boton-rojo-block" type="submit" value = "eliminar"></form>
                        </form>
                        <a class = "boton-amarillo-block" href = "/propiedades/actualizar?id=<?php echo $propiedad->id; ?>">Actualizar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h2>Vendedores</h2>

        <table class = "propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody> <!-- MOSTRAR RESULTADOS-->
                <?php foreach($vendedores as $vendedor): ?>
                <tr>
                    <td><?php echo $vendedor->id;?></td>
                    <td><?php echo $vendedor->nombre . " " . $vendedor->apellido;?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <form method="POST" class = "w-100" action = "/vendedores/eliminar">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id; ?>" > <!--Permite enviar datos de forma oculta-->
                            <input type="hidden" name="tipo" value="vendedor" >
                            <input class = "boton-rojo-block" type="submit" value = "eliminar"></form>
                        </form>
                        <a href="vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a> 
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>