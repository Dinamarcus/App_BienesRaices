<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router) {
        $propiedades = Propiedad::get(3);
        $inicio = true;

        $router->render('paginas/index', ['propiedades'=> $propiedades, 'inicio'=> $inicio]);
    }
    public static function nosotros(Router $router) {
        $router->render('paginas/nosotros', []);
    }
    public static function propiedades(Router $router) {
        $propiedades = Propiedad::all();

        $router->render('paginas/propiedades', ['propiedades'=>$propiedades]);
    }
    public static function propiedad(Router $router) {
        $id = validarOredireccionar('/propiedades');

        //Buscar propiedad por id
        $propiedad = Propiedad::find($id);

        $router->render('paginas/propiedad', ['propiedad'=>$propiedad]);
    }
    public static function blog(Router $router) {
        $router->render('paginas/blog', []);
    }
    public static function entrada(Router $router) {
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router) {

        $mensaje = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $respuestas = $_POST['contacto'];

            //Crear una nueva instancia de PHPmailer. Esta libreria esta orientada a objetos por eso el crear la instancia
            $mail = new PHPMailer();

            //Configurar SMTP, que es protocolo que se utilica para el envio de emails.
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io'; //Dominio o Host
            $mail->SMTPAuth = true; //Autenticacion
            $mail->Username = 'a81ff37f63869f';
            $mail->Password = '171e9187ab0cb0';
            $mail->SMTP = 'tls'; //TLS (Transport Layer Security). Es la encriptacion. La otra forma es SSL (Secure Sockets Layer).
            $mail->Port = 2525;

            //Configurar el contenido del email
            $mail->setFrom('admin@bienesraices.com'); //Quien envia el mail
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //A que email va a llegar ese correo
            $mail->Subject = 'Tienes un nuevo mensaje';
            

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            //Definir el contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . ' </p>';

            //Enviar de forma condicional algunos campos de email o telefono
            if ($respuestas['contacto1'] === 'telefono') {
                $contenido .= '<p>Eligio ser contactado por telefono</p>';
                $contenido .= '<p>Telefono: ' . $respuestas['telefono'] . ' </p>';
                $contenido .= '<p>Fecha contacto: ' . $respuestas['fecha'] . ' </p>';
                $contenido .= '<p>Hora contacto: ' . $respuestas['hora'] . ' </p>';
            } else {
                //Es email, entonces agregamos el campo de email
                $contenido .= '<p>Eligio ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . ' </p>';
            }

            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . ' </p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . ' </p>';
            $contenido .= '<p>Precio o presupuesto: $' . $respuestas['precio'] . ' </p>';
            $contenido .= '<p>Prefiere ser contactado por: ' . $respuestas['contacto1'] . ' </p>';
            $contenido .= '</html>'; 

            $mail->Body = $contenido;
            $mail->AltBody = 'Texto alternativo sin html'; //Esto es lo que se muestra cuando el lector de mails no soporta html
            
            //Enviar el email, la funcion send devuelve true o false
            if ($mail->send()) {
                $mensaje = "Mensaje enviado correctamente";
            } else {
                $mensaje = "Mensaje no enviado";
            }
        }

        $router->render('paginas/contacto', ['mensaje'=>$mensaje]);
        
    }
    public static function contado() {
    }
}


