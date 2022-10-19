<?php

namespace Model;

class Admin extends ActiveRecord {
    //Base de datos, ambas variables llevan protected y static delante ya que solo accederemos a ellas dentro de esta clase y son siempre las mismas.
    protected static $tabla = 'usuarios'; 
    protected static $columnasDB = ['id', 'email', 'password'];

    public $id;
    public $email;
    public $password;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->email = $args['email'] ?? '';
        $this->password= $args['password'] ?? '';
    }

    public function validar() {
        if (!$this->email) {
            self::$errores[] = 'El mail es obligatorio';
        }
        if (!$this->password) {
            self::$errores[] = 'El password es obligatorio';
        }

        return self::$errores;
    }

    public function existeUsuario() {
        //Revisar si un usuario existe o no
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$db->query($query); //Si debuggeo $resultado y luego envio post, en num rows deberia estar el valor 1 para saber que esta bien.

        if(!$resultado->num_rows) {
            self::$errores[] = "El usuario no existe";
            return;
        }

        return $resultado;
    }

    public function comprobarPassword($resultado) {
        $usuario = $resultado->fetch_object(); //Nos trae el resultado de lo que encontro en la db.

        $autenticado = password_verify($this->password, $usuario->password); //El primer parametro es lo que el usuarip escribio y el segundo el password hasehado. Revisa que lo que escribimos en el input sea el password hasheado

        if (!$autenticado) {
            self::$errores[] = "El password es incorrecto";
        }

        return $autenticado;
    }
    
    public function autenticar() {
        session_start(); //Inicia la sesion

        //Llenar el arrreglo de sesion
        $_SESSION['usuario'] = $this->email;
        $_SESSION['login'] = true;

        header('Location: /admin');
    }
}