<?php 

namespace Controllers;
use MVC\Router;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class VendedorController {
    public static function crear(Router $router) {
        $errores = Vendedor::getErrores();
        
        $vendedor = new Vendedor;

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Nueva instancia de vendedor
            $vendedor = new Vendedor($_POST['vendedor']);
        
            //validar que no haya campos vacios
            $errores = $vendedor->validar();
        
            //no hay errores
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router -> render('vendedores/crear', ['errores'=> $errores, 'vendedor'=>$vendedor]);
    }

    public static function actualizar(Router $router) { 
        $errores = Vendedor::getErrores();

        $id = validarOredireccionar('/admin');

        //Obetener datos del vendedor a actualizar
        $vendedor = Vendedor::find($id);


        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Nueva instancia de vendedor
            $vendedor = new Vendedor($_POST['vendedor']);
        
            //validar que no haya campos vacios
            $errores = $vendedor->validar();
        
            //no hay errores
            if (empty($errores)) {
                $vendedor->guardar();
            }
        }

        $router->render('vendedores/actualizar', ['errores'=> $errores,
        'vendedor'=> $vendedor]);
    }

    public static function eliminar() { //No requiere router ya que no renderizaremos nada
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Validar el id
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {
                //Valida el tipo a eliminar
                $tipo = $_POST['tipo']; 

                if (validarTipoContenido($tipo)) {
                    $vendedor = Vendedor::find($id);
                    $vendedor->eliminar();
                }
            }
        }
    }
}