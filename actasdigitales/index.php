<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');

require_once './modelos/UsersModel.php';
require_once './modelos/RecordsModel.php';
require_once './modelos/MeetingsModel.php';
require_once './controladores/UsersController.php';
require_once './controladores/RecordsController.php';
require_once './controladores/MeetingsController.php';
require_once './conexion/DB.php';
include_once './views/view.php';

$con = DB::getInstance(); 

function createControllers($con, $controllers) {
    $instances = [];
    foreach ($controllers as $controller) {
        $modelClass = $controller . 'Model';
        $controllerClass = $controller . 'Controller';
        
        if (class_exists($modelClass) && class_exists($controllerClass)) {
            $model = new $modelClass($con);
            $instances[$controller] = new $controllerClass($model);
        } else {
            throw new Exception("Classes for $controller do not exist.");
        }
    }
    return $instances;
}


$controllerNames = ['User', 'Record', 'Meeting'];
$controllers = createControllers($con, $controllerNames);

$requestMethod = $_SERVER['REQUEST_METHOD'];

$route = $_GET['route'] ?? '';

switch ($route) {
    case 'users':
        $response = $controllers['User']->handleRequest($requestMethod);
        break;
    case 'records':
        $response = $controllers['Record']->handleRequest($requestMethod);
        break;
    case 'meetings':
        $response = $controllers['Meeting']->handleRequest($requestMethod);
        break;
    default:
        $response = ['error' => 'Ruta no válida'];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
