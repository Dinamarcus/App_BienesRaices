<?php 

namespace Model;

class ActiveRecord {
    //DB
    protected static $db; //Al ser estatico no se resscribe cada vez que se ejecuta, es siempre el mismo.
    protected static $columnasDB = []; //Este arreglo nos mpermite identificar que forma tendran los datos que columnas van a tener. Permite mapear y unir los atributos
    protected static $tabla = '';

    //errores 
    protected static $errores = [];

    //Definir conexion a la DB
    public static function setDB($database) {
        self::$db = $database; //Self para hacer referencia a lo que sea con static
    }

    public function guardar() {
        if (!is_null($this->id)) {
            //actualizar
            $this->actualizar();
        } else {
            //creando nuevo registro
            $this->crear();
        }
    }

    public function crear() {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar los valores de lo colocamos en el formulario en la DB.
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos)); 
        $query .= " ) VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') "; //Array values y keys permite acceder a los elementos del array y join los aplana en un string. El operador .= es para concatenar con la siguiente linea

        $resultado = self::$db->query($query);
        
        //Mensaje de exito
        if ($resultado) {
            header('Location: /admin?resultado=1');
        }
    } 

    public function actualizar() {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = []; // Ir a la memoria, ir al objeto en memoria y va a ir uniendo atributos con valores
        foreach($atributos as $key=>$value) {
            $valores[] = "{$key} = '{$value}'"; //Lo que hace este codigo 
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; //IMPORTANTE DEJAR LOS ESPCIOS LUEGO DE LAS COMILLAS DOBLE

        $resultado = self::$db->query($query);

        if($resultado) {
            // echo "insertado correctamente";
            header('Location: /admin?resultado=2'); //PARA REDIRECCIONAR AL USUARIO UNA VEZ QUE ENVIA EL FORMULARIO. FUNCIONA SI NO HAY HTML PREVIO A ESTE CODIGO. El querystring es el que tiene el signo ?, que aparecera una vez cargada una propiedad en la url, en este caso como el mensaje.
        }
    }

    //Eliminar un registro
    public function eliminar() {
        //ELiminar el archivo 
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";

        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('location: /admin?resultado=3');
        }        
    }

    //Identificar y unir los atributos de la DB
    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue; //continua al proximo elemento del arreglo que recorre el foreach. No lo va a agregar a atributos
            $atributos[$columna] = $this->$columna; 
        } 

        return $atributos;
    }

    //Sanitizar los atributos
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        
        foreach($atributos as $key => $value) { 
          $sanitizado[$key] = self::$db->escape_string($value); //sanitiza el dato que el usuario ingresa, si ingresa un apstrofe por ejemplo lo escapa antes de guardarlo

        } //Lo recorremos como un arreglo asociativo. Es como un objeto de Js. Key es la clave y value el que asigna el usuario

        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen) {
        //Elimina la imagen previa antes de asignarla
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }
        
        //Asignar al atributo de imagen el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Borrar imagen
    public function borrarImagen() {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETAS_IMAGENES . $this->imagen); //Busca el archivo y si lo encuentra devuelve un true
        if ($existeArchivo) {
            unlink(CARPETAS_IMAGENES . $this->imagen);
        }
    }

    //validacion
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];

        return static::$errores;
    }

    //Listar todas las propíedades
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla; //retorna un arreglo asociativo. Static mantiene el metodo cuando se hereda y lo que hace es buscar el atributo que se busca en la clase donde se este heredando.
        $resultado = static::consultarSql($query);

        return $resultado;
    }

    //Obtiene determinado numero de registros
    public static function get($cantidad) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ". $cantidad; //retorna un arreglo asociativo. Static mantiene el metodo cuando se hereda y lo que hace es buscar el atributo que se busca en la clase donde se este heredando.

        $resultado = static::consultarSql($query);

        return $resultado;
    }

    //Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        $resultado = self::consultarSql($query);

        return array_shift($resultado); //esta funcion devuelve la primera posicion del array 
    }

    public static function consultarSql($query) {
        //Consultar la base de datos
        $resultado = self::$db->query($query); //Todo lo que involucre la base de datos utiliza el self::$db

        //Iterar los resultados
        $array = [];
        while ($registro = $resultado-> fetch_assoc()) {
            $array[] = static::crearObjeto($registro); //Es un array asociativo, se le agregan los objetos del metodo crearobejto
        }

        //Liberar la memoria, para ayudar al servidor
        $resultado->free(); 

        //retornar los resultados
        return $array;
    }

    //Este metodo toma los resultados de la base de datos y esta creando un objeto en memoria que es un espejo de lo que hay en la base de datos
    protected static function crearObjeto($registro) {
        $objeto = new static;


        foreach($registro as $key=>$value) { //va a ir comprobando que tenga la forma que se busca y va air mapeando los datos de arreglos hacia objetos que se quedan en memoria
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto; //Retorna los objetos
    }

    //Sincroniza el opbjeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = []) {
        foreach($args as $key=>$value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}