<fieldset>
    <legend>Informacion general</legend>         

    <label for = "nombre">Nombre:</label>
    <input type="text" name="vendedor[nombre]" id="nombre" placeholder="Nombre vendedor(a)" value = "<?php echo s($vendedor->nombre);?>"> 

    <label for = "nombre">Apellido:</label>
    <input type="text" name="vendedor[apellido]" id="apellido" placeholder="Apellido vendedor(a)" value = "<?php echo s($vendedor->apellido);?>">
    
</fieldset>

<fieldset>
    <legend>Informacion Extra</legend>

    <label for = "nombre">Telefono:</label>
    <input type="text" name="vendedor[telefono]" id="telefono" placeholder="Telefono vendedor(a)" value = "<?php echo s($vendedor->telefono);?>"> 
</fieldset>