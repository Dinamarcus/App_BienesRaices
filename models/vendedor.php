<?php 

namespace Model;

class Vendedor extends ActiveRecord {
    protected static $tabla = 'vendedores'; //cuando se hereda ActiveRecord, vendedores tiene su propia tabla donde consultar

    protected static $columnasDB = ['id', 'nombre', 'apellido', 'telefono']; //cuando se hereda ActiveRecord, vendedores tiene sus propias columnas donde consultar.

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    public function validar() {

        if(!$this->nombre) {
            self::$errores[] = "Debes añadir un nombre";
        }

        if(!$this->apellido) {
            self::$errores[] = "Debes añadir un apellido";
        }
        if(!$this->telefono) {
            self::$errores[] = "Debes añadir un telefono";
        }

        if (!preg_match('/[0-9]{10}/', $this->telefono) or strlen($this->telefono) > 10) { //EXPRESION REGULARr, una forma de buscar un patron dentro de un texto. Ej, si tengo un correo electronico todos deben tener ese patron de tener un @hotmail.com o la que sea pero similar a esa.  En el caso de la funcion le estamos diciendo que acepte digitos entre el 0 y 9 y un maximo de 10
            self::$errores[] = "Formato no Valido";

        }

        return self::$errores;
    }
}