<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');

require_once './modelos/UsersModel.php';
require_once './controladores/UsersController.php';
require_once './conexion/DB.php';
include_once './views/view.php';

$con = DB::getInstance(); // Inicializar la conexión
$userController = new UserController(new UserModel($con));
$method = $_SERVER['REQUEST_METHOD'];
$inputJSON = file_get_contents('php://input');
$input = json_decode($inputJSON, true);

// Manejar la solicitud según el método
switch ($method) {
    case 'GET':
        if (isset($_GET['id_user'])) {
            // Obtener un usuario por ID
            $userId = $_GET['id_user'];
            $user = $userController->getUserByID($userId);
            View::returnJSON($user);
        } else {
            // Obtener todos los usuarios
            $users = $userController->getAllUsers();
            View::returnJSON($users);
        }
        break;
    case 'POST':
        // Crear un nuevo usuario
        $id = $input['id_user'];
        $name = $input['name'];
        $email = $input['email'];
        $role = $input['rol'];
        $password = $input['password'];
        $result = $userController->createUser($id, $name, $email, $role, $password);
        echo json_encode(['success' => $result > 0]);
        break;
    case 'PUT':
        // Actualizar un usuario existente
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = $input['id_user'];
        $name = $input['name'];
        $email = $input['email'];
        $role = $input['rol'];
        $password = $input['password'];
        $result = $userController->updateUser($id, $name, $email, $role, $password);
        echo json_encode(['success' => $result > 0]);
        break;
        
    case 'DELETE':
        // Eliminar un usuario
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = $input['id_user'];
        $result = $userController->deleteUser($id);
        echo json_encode(['success' => $result > 0]);
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        break;
}
?>
