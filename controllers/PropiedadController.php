<?php 

namespace Controllers;
use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController {

    //Toma como referencia al router que se encuentra en el index.php donde se crea la instancia nueva del router
    public static function index(Router $router) { 
        $propiedades = Propiedad::all(); //Llamado a la base de datos

        $vendedores = Vendedor::all();

        //mensaje condicional
        $resultado = $_GET['resultado'] ?? null; //?? es un placeholder, similar a un isset, y lo que ahce es buscar el valor del get y si no lo encuentra le asigna null. En este caso si la url tiene resultado, activara el codigo para la alerta de subida.

        $router->render('propiedades/admin', ['propiedades'=>$propiedades, 'vendedores'=>$vendedores, 'resultado' => $resultado]); //Renderiza el html. Le pasamos la consulta de la DB.
    }

    public static function crear(Router $router) {
        $propiedad = new Propiedad; //nueva instancia
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        if($_SERVER['REQUEST_METHOD'] === 'POST') { /**Es una forma de validacion donde cuando nosotros enviamos los datos que completamos en el formulario, el array del metodo POST aparecera lleno con esos datos.*/

            $propiedad = new Propiedad($_POST['propiedad']); //Creamos una instacia una vez que se envien los datos desde el formulario y se almacenan en memoria, lo que nos permite ver los atributos del objeto
        
            /**SUBIDA DE ARCHIVOS */
            //Generar nombre unico
            $nombreImagen = md5(uniqid( rand(), true )) . ".jpg"; //md5 se usaba para crear un hash, tomar una entrada y convertirla. Entra algo y genera otra cosa que en este caso sera el nombre extraño. uniqueid hace que el nombre no se repita. rand genera un numero entero aleatorio.
        
            //Setear la imagen
            //Realiza un resize a la imagen con intervention
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
            }
            
            //validar
            $errores = $propiedad->validar();
        
            if (empty($errores)) { //SI EL ARRAY ESTA VACIO SE EJECUTA ESTE CODIGO QUE GUARDA EL REGISTRO EN LA DB.
        
            //Crear la carpeta para subir imagenes
            if (!is_dir(CARPETAS_IMAGENES)) {
                mkdir(CARPETAS_IMAGENES);
            }
            
            //Guarda la imagen en el servidor
            $image->save(CARPETAS_IMAGENES . $nombreImagen);
        
            //Guardar en la DB
            $propiedad->guardar();
        }
        
        }

        $router->render('propiedades/crear', ['propiedad' => $propiedad,
        'vendedores' => $vendedores,
        'errores' => $errores]);
    }

    public static function actualizar(Router $router) {
        $id = validarOredireccionar('/admin'); //Redirecciona al usuario a admin si el id de la url no es un entero



        $propiedad = Propiedad::find($id);
        $vendedores = Vendedor::all();
        $errores = Propiedad::getErrores();

        //Metodo POST para actualizar 
        if($_SERVER['REQUEST_METHOD'] == 'POST') { 
            /**Es una forma de validacion donde cuando nosotros enviamos los datos que completamos en el formulario, el array del metodo POST aparecera lleno con esos datos.*/

            //Asignar los atributos
            $args = $_POST['propiedad'];
            
            $propiedad->sincronizar($args); //Sincroniza los datos de lo que el usuario escribe con el objeto en memoria
            
            //validacion
            $errores = $propiedad->validar();
            
            //Subida de archivos
            $nombreImagen = md5(uniqid( rand(), true )) . ".jpg";
            
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
                $propiedad->setImagen($nombreImagen);
            }
            
            //INSERTAR EN LA DB
            if (empty($errores)) { //SI EL ARRAY ESTA VACIO SE EJECUTA ESTE CODIGO QUE GUARDA EL REGISTRO EN LA DB.
            //Almacenar la imagen
            if ($_FILES['propiedad']['tmp_name']['imagen']) {
                    $image->save(CARPETAS_IMAGENES . $nombreImagen);
                }
                    $propiedad->guardar();
            }
        }

        $router -> render('/propiedades/actualizar', ['propiedad'=> $propiedad,
        'errores'=>$errores,
        'vendedores'=> $vendedores]); //Nos traemos las propiedades, errores, etc y los cargamos al view añadiendolos al array

    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
        
            if ($id) {
        
                $tipo = $_POST['tipo'];
        
                if (validarTipoContenido($tipo)) {
                    //compara lo que vamos a eliminar
                    $propiedad = Propiedad::find($id); 
                    $propiedad->eliminar();
                }
            }
        }
    }
}