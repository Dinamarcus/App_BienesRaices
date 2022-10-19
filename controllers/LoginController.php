<?php 

namespace Controllers;
use MVC\Router;
use Model\Admin;



class LoginController {
    public static function login ($router) {
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Admin($_POST); //Crea una nueva instancia con lo que hay en post

            $errores = $auth->validar();

            if (empty($errores)) {
                //Verificar si el usuario existe
                $resultado = $auth->existeUsuario();
                if (!$resultado) {
                    $errores = Admin::getErrores(); 
                } else {
                //autenticar al password
                $autenticado = $auth->comprobarPassword($resultado);
                    
                if ($autenticado) {
                    //autenticar usuario
                    $auth->autenticar();

                } else {
                    //Mensaje de pass incorrecta
                    $errores = Admin::getErrores();                
                }
                //verificar el password

                }
            }
        }

        $router->render('auth/login', ['errores'=> $errores]);
        
    }

    public static function logout () {
        session_start();

        $_SESSION = [];

        header('Location: /');
    }
}