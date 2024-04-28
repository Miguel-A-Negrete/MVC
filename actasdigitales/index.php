<?php

require_once './modelos/UsersModel.php';
require_once './controladores/UsersController.php';

$pdo = new PDO('mysql:host=localhost;dbname=actasdigitales', 'root', '');
$userController = new UserController(new UserModel($pdo));
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
            echo json_encode($user);
        } else {
            // Obtener todos los usuarios
            $users = $userController->getAllUsers();
            echo json_encode($users);
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