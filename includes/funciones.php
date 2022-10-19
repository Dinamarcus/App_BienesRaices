<?php

define('TEMPLATES_URL', __DIR__ /*para que tome la ubicacion del archivo, es una superglobal de php*/. '/templates');
define('FUNCIONES_URL',__DIR__ . 'funciones.php');
define('CARPETAS_IMAGENES', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/'); //ES UNA CONSTANTE AL IGUAL QUE LAS DE ARRIBA

function incluirTemplate(string $nombre, bool $inicio = false /*En caso de que la variable inicio no este presente, tomara ese valor por default y no hace falta tener el isset en header. No hace falta comprobacion*/) { /*Los tipos delnte de las variables son los php types y se les da uso para esto por ejemplo. Definen el tipo de dato que tendra el parametro */
    include TEMPLATES_URL . "/${nombre}.php";
}

function autenticado() { //retorna un booleano
    session_start();

    if (!$_SESSION['login']) {     //El array de session con su elemento login 
    header('Location: /');
    } 
}

function debuggear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

//Escape/sanitizar HTML
function s($html) : string {
    $s = htmlspecialchars($html); //sanitiza el html

    return $s;
}

//validar tipo de contenido
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];
    
    return in_array($tipo, $tipos); //permite buscar un array o valor dentro de un arreglo
}

//Muestra los mensajes de alerta
function mostrarNotificacion($codigo) {
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Creado Correctamente';
        break;
        case 2:
            $mensaje = 'Actualizado Correctamente';
        break;
        case 3:
            $mensaje = 'Eliminado Correctamente';
        break;

        default:
            $mensaje = false;
        break;

    }
    return $mensaje;
}

///Redirecciona al usuario a una url si el id de la url no es un entero
function validarOredireccionar(string $url) {
    //Validar URL por ID valido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT); //Los filtros de PHP se utilizan para validar un tipo de dato, por ejemplo si en un input de tipo number ingresamos letras el filtro se encargara de limpiar las letras y dejar solo los numeros. Asi existen muchos filtros que cumplen la misma funcion pero con otros tipos de datos.

    if (!$id) {
        header("Location: ${url}"); 
    }

    return $id;
}