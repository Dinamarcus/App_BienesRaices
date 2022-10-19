<?php //ARCHIVO PRINCIPAL, todo lo que agregue aca estara disponible en los otros archivos

require __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'funciones.php';
require 'config/database.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');

//Conectar a la DB
$db = conectarDB();
$db->set_charset('utf8');  

use Model\ActiveRecord;

ActiveRecord::setDB($db);

