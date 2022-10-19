            <fieldset>
                <legend>Informacion general</legend>
                
                <label for = "titulo">Titulo</label>
                <input type="text" name="propiedad[titulo]" id="titulo" placeholder="Titulo propiedad" value = "<?php echo s($propiedad->titulo);?>"> <!--LO QUE EL USUARIO ESCRIBA ACA SE ALMACENA EN LA BD-->
                
            <!--Los echo dentro de los input hacen que se guarde informacion ingresada anteriormente en los campos. Ademas de que si ingresamos algunos valores y aun no hemos completado otros campos, todavia seguiremos teniendo la posibilidad de completarlo sin que el validador nos lo rechaze.-->

                <label for = "precio">Precio:</label>
                <input type="number" name="propiedad[precio]" min="1" id="precio" placeholder="Precio propiedad" value = "<?php echo s($propiedad->precio);?>">
                
                <label for = "imagen">Imagen:</label>
                <input type="file" id="imagen" placeholder="Insertar imagen" accept="image/jpeg, image/png" name = "propiedad[imagen]" >    

                <?php if($propiedad->imagen) { ?>
                    <img src="/imagenes/<?php echo $propiedad->imagen ?>" class = "imagen-small">
                <?php } ?>
                <label for = "descripcion">Descripcion:</label>
                <textarea name="propiedad[descripcion]" id="descripcion"><?php echo s($propiedad->descripcion);?></textarea>
                
            </fieldset>
            
            <fieldset>
                <legend>Informacion propiedad</legend>

                <label for = "habitaciones">Habitaciones:</label>
                <input type="number" name="propiedad[habitaciones]" id="habitaciones" placeholder="Ej: 3." min = "1" max="9" value = "<?php echo s($propiedad->habitaciones);?>">
                
                <label for = "wc">Baños:</label>
                <input type="number" name="propiedad[wc]" id="wc" placeholder="Ej: 3." min = "1" max="9" value = "<?php echo s($propiedad->wc);?>">   
                
                <label for = "estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="propiedad[estacionamiento]" placeholder="Ej: 3." min = "1" max="9" value = "<?php echo s($propiedad->estacionamiento);?>">    
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>
                <label for = "vendedor">Vendedor</label>
                <select name = "propiedad[vendedorId]" id = "vendedor">
                    <option selected value = "" disabled> --Seleccione vendedor --</option>   
                    <?php foreach($vendedores as    $vendedor) { ?>
                    <option <?php echo $propiedad->vendedores_id === $vendedor->id? 'selected' : ''; ?> value = "<?php echo s($vendedor->id); ?>"> <?php echo s($vendedor->nombre) . " " . s($vendedor->apellido); ?> </option>
                    <?php } ?>
                </select>
            </fieldset>