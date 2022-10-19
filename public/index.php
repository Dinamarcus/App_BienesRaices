<!--En este archivo vamos a almacenar urls que van a mandar a llamar a metodos de los controladores que tienen asociado-->
<?php 

require_once __DIR__ . '/../includes/app.php'; //importar conexion a Db y demas

use Controllers\LoginController;
use MVC\Router;
use Controllers\PropiedadController;
use Controllers\VendedorController;
use Controllers\PaginasController;

$router = new Router();

//Zona privada
$router->get('/admin', [PropiedadController::class, 'index']); //Recibe de parametros una URL que voy a visitar y un array donde el primer codigo Nos permite identificar en que clase se encuentra el metodo y el segundo es el metodo, hace referencia al controlador. Reacciona al metodo GET.
$router->get('/propiedades/crear', [PropiedadController::class, 'crear']); 
$router->post('/propiedades/crear', [PropiedadController::class, 'crear']);
$router->post('/propiedades/eliminar', [PropiedadController::class, 'eliminar']);
$router->get('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->post('/propiedades/actualizar', [PropiedadController::class, 'actualizar']);
$router->get('/vendedores/crear', [VendedorController::class, 'crear']); 
$router->post('/vendedores/crear', [VendedorController::class, 'crear']);
$router->post('/vendedores/eliminar', [VendedorController::class, 'eliminar']);
$router->get('/vendedores/actualizar', [VendedorController::class, 'actualizar']);
$router->post('/vendedores/actualizar', [VendedorController::class, 'actualizar']);

//Zona publica
$router->get('/', [PaginasController::class, 'index']);
$router->get('/nosotros', [PaginasController::class, 'nosotros']);
$router->get('/propiedades', [PaginasController::class, 'propiedades']);
$router->get('/propiedad', [PaginasController::class, 'propiedad']);
$router->get('/blog', [PaginasController::class, 'blog']);
$router->get('/entrada', [PaginasController::class, 'entrada']);
$router->get('/contacto', [PaginasController::class, 'contacto']);
$router->post('/contacto', [PaginasController::class, 'contacto']);

//Login y autenticacion
$router->get('/login', [LoginController::class, 'login']);
$router->post('/login', [LoginController::class, 'login']);
$router->get('/logout', [LoginController::class, 'logout']);



$router->comprobarRutas(); //Comprueba que las rutas esten definidas en el Router y tambien el tipo de request.


