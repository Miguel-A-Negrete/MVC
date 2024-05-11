<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: X-Requested-With');

require_once './modelos/UsersModel.php';
require_once './modelos/RecordsModel.php';
require_once './controladores/UsersController.php';
require_once './controladores/RecordsController.php';
require_once './conexion/DB.php';
include_once './views/view.php';

$con = DB::getInstance(); // Inicializar la conexión
$userController = new UserController(new UserModel($con));
$recordController = new RecordController(new RecordModel($con));
$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';

// Manejar la solicitud según el método
switch ($method) {
    case 'GET':
        try {
            if (isset($_GET['id_user'])) {
                $userId = $_GET['id_user'];
                $user = $userController->getUserByID($userId);
                View::returnJSON($user);
                exit; // Punto de salida único
            }

            if($_GET['id_user'] == null){
            // Obtener todos los usuarios
            $users = $userController->getAllUsers();
            View::returnJSON($users);
            exit;
            }


        } catch (Exception $e) {
            View::returnJSON(['error' => $e->getMessage()]);
            exit; // Punto de salida único para errores
        }
        break;

    case 'POST':
        // Acceder a datos POST de manera segura
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $userId = isset($_POST['id_user']) ? $_POST['id_user'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $role = isset($_POST['rol']) ? $_POST['rol'] : null;
        $asunto = isset($_POST['asunto']) ? $_POST['asunto'] : null;
        $responsibleID = isset($_POST['responsable']) ? $_POST['responsable'] : null;
        $date = isset($_POST['fecha']) ? $_POST['fecha'] : null;
        $start_time = isset($_POST['hora_inicio']) ? $_POST['hora_inicio'] : null;
        $end_time = isset($_POST['hora_fin']) ? $_POST['hora_fin'] : null;
        $privacy = isset($_POST['privacidad']) ? $_POST['privacidad'] : null;
        $relacion_acta = isset($_POST['relacion_acta']) ? $_POST['relacion_acta'] : null;

        if ($username !== null && $password !== null && $userId !== null) {
            $result = $userController->createUser($userId, $name, $username, $role, $password);
            if ($result > 0) {
                session_start();
                $_SESSION['email'] = $username;
                header("Location: home.html");
            } else {
                // Manejo de falla en la aprobación del usuario
                echo "Registro inválido.";
            }
        }

        if ($username !== null && $password !== null) {
            $result = $userController->getUserApprobation($username, $password);
            if ($result) {
                session_start();
                $_SESSION['email'] = $username;
                header("Location: actas.php");
            } else {
                // Manejo de falla en la aprobación del usuario
                echo "Credenciales inválidas.";
            }
        }

        if ($asunto !== null) {
            $result = $recordController->createRecord($date, $start_time, $end_time, $asunto, $responsibleID, $privacy, $relacion_acta);
            if ($result > 0) {
                echo "Acción realizada con éxito";
            } else {
                echo "Ocurrió un error al crear el acta";
            }
        }
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
