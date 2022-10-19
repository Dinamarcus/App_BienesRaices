<?php 

namespace MVC;

class Router {
    public $rutasGET = []; //Almaacena la ruta y su funcion
    public $rutasPOST = [];

    //Soporte a rutas de GET
    public function get($url, $fn) {
        $this->rutasGET[$url] = $fn;
    }
    
    //Soporte a rutas de POST
    public function post($url, $fn) {
        $this->rutasPOST[$url] = $fn;
    }

    public function comprobarRutas() {

        session_start();

        $auth = $_SESSION['login'] ?? null;
        
        //Arreglo de rutas protegidas
        $rutas_protegidas = ['/admin', 'propiedades/crear', 'propiedades/actualizar','propiedades/eliminar', 'vendedores/crear','vendedores/eliminar', 'vendedores/actualizar'];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        if ($metodo === 'GET') {
            $fn = $this->rutasGET[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPOST[$urlActual] ?? null;
        }

        //Proteger las rutas
        if (in_array($urlActual, $rutas_protegidas) && !$auth) {
            header('Location: /');
        } //Si el usuario no esta autenticado y ademas la url que se quiere acceder es una url protegida, te redirige
        
        if ($fn) {
            //La URL existe y hay una funcion asociada
            call_user_func($fn, $this); //Esta funcion manda a llamar a una funcion cuando no sabemos su nombre. Recibe de parametro la funcion y la instacia del router que contendra als url's. El this hace referencia a las dos intancias de arriba
        } else {
            echo "Pagina no encontrada";
        }

    }

    //Muestra una vista
    public function render($view, $datos = []) {

        //Generar variables con nombre de los keys del arreglo asociativo que le pasamos a la vista
        foreach($datos as $key=>$value) {
            $$key = $value; // con este codigo decimos que lo que este dentro de una llave tendra el valor de value. El doble signo significa variable de variable y mantiene el nombre pero no pierde el valor
        }
        ob_start(); //Inicia un almacenamiento en memoria durante un momento
        
        include __DIR__. "/views/$view.php"; // __DIR__ hace referencia a la raiz del proyecto
        $contenido = ob_get_clean(); // Limpia la memoria. A lo que nosotros le vayamos dando render se va a guardar en esta variable de contenido

        include __DIR__ . "/views/layout.php"; // Al poner esto lo que este en la variable de contenido se va a insertar en el layout donde tenemos nuestra variable contenido
    }
}