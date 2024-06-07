<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once './modelos/UsersModel.php';
require_once './modelos/RecordsModel.php';
require_once './modelos/MeetingsModel.php';
require_once './controladores/UsersController.php';
require_once './controladores/RecordsController.php';
require_once './controladores/MeetingsController.php';
require_once './conexion/DB.php';
require_once './conexion/Jwt.php';
include_once './views/view.php';

$con = DB::getInstance();

function createControllers($con, $controllerNames) {
    $instances = [];
    foreach ($controllerNames as $controller) {
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

function checkJWT() {
    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        return false;
    }

    $authHeader = $_SERVER['HTTP_AUTHORIZATION'];
    list($jwt) = sscanf($authHeader, 'Bearer %s');

    if (!$jwt) {
        return false;
    }

    try {
        $JwtController = new Jwt(Config::SECRET_KEY);
        $payload = $JwtController->decode($jwt);
        return $payload;
    } catch (Exception $e) {
        return false;
    }
}

$controllerNames = ['User', 'Record', 'Meeting'];
$controllers = createControllers($con, $controllerNames);

$requestMethod = $_SERVER['REQUEST_METHOD'];

$route = $_GET['route'] ?? '';

if (in_array($route, $controllerNames) && !checkJWT()) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit();
}

$response = null;
try {
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
} catch (Exception $e) {
    http_response_code(500);
    $response = ['error' => 'Error del servidor interno', 'message' => $e->getMessage()];
}

header('Content-Type: application/json');
echo json_encode($response);
?>
