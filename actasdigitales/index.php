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

$userController = new UserController(new UserModel($con));
$recordController = new RecordController(new RecordModel($con));
$meetingController = new MeetingController(new MeetingModel($con));

$requestMethod = $_SERVER['REQUEST_METHOD'];

$route = $_GET['route'] ?? '';

switch ($route) {
    case 'users':
        $response = $userController->handleRequest($requestMethod);
        break;
    case 'records':
        $response = $recordController->handleRequest($requestMethod);
        break;
    case 'meetings':
        $response = $meetingController->handleRequest($requestMethod);
        break;
    default:
        $response = ['error' => 'Ruta no válida'];
        break;
}

header('Content-Type: application/json');
echo json_encode($response);
?>