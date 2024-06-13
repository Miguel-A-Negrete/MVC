<?php
require_once './conexion/Conexion.php';
require_once './conexion/Jwt.php';

class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function handleRequest($method) {
        switch ($method) {
            case 'GET':
                return $this->handleGET();
            case 'POST':
                return $this->handlePOST();
            case 'PUT':
                return $this->handlePUT();
            case 'DELETE':
                return $this->handleDELETE();
            default:
                return ['error' => 'Método no permitido'];
        }
    }

    private function handleGET() {
        try {
            if (isset($_GET['id_user'])) {
                $userId = $_GET['id_user'];
                $user = $this->getUserByID($userId);
                return $user;
            } else {
                // Obtener todos los usuarios
                return $this->getAllUsers();
            }
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    private function handlePOST() {
        $input = json_decode(file_get_contents('php://input'), true);

        $username = filter_var($input['username'] ?? null, FILTER_SANITIZE_STRING);
        $password = filter_var($input['password'] ?? null, FILTER_SANITIZE_STRING);


        if ($username !== null && $password !== null) {
            try{
                $result = $this->getUserApprobation($username, $password);
                if ($result) {
                    $id = $this->getUserID($username);
                    
                    $payload = [
                        "id" => $id['id_user'],
                        "exp" => time() + (60*60)
                    ];
    
                    $JwtController = new Jwt(Config::SECRET_KEY);
                    $token = $JwtController->encode($payload);
    
                    return ['token' => $token, 'success' => true];
                } else {
                    return ['error' => 'Credenciales inválidas.'];
                }
            } catch(PDOException $e){
                return ['error' => 'Error al conectar con la base de datos'];
            } catch (Exception $e){
                return ['error' => $e->getMessage()];
            }
        } else {
            return ['error' => 'Username y password son requeridos.'];
        }
    }

    private function handlePUT() {
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = $_PUT['id_user'] ?? null;
        $name = $_PUT['name'] ?? null;
        $email = $_PUT['email'] ?? null;
        $role = $_PUT['rol'] ?? null;
        $password = $_PUT['password'] ?? null;

        $result = $this->updateUser($id, $name, $email, $role, $password);
        return ['success' => $result > 0];
    }

    private function handleDELETE() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = $_DELETE['id_user'] ?? null;
        $result = $this->deleteUser($id);
        return ['success' => $result > 0];
    }

    private function createUser($id, $name, $email, $role, $password) {
        return $this->userModel->createUser($id, $name, $email, $role, $password);
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    public function getUserByID($id) {
        return $this->userModel->getUserByID($id);
    }

    private function getUserApprobation($email, $password) {
        return $this->userModel->getUserApprobation($email, $password);
    }

    public function getUserID($email) {
        return $this->userModel->getUserID($email);
    }

    private function updateUser($id, $name, $email, $role, $password) {
        return $this->userModel->updateUser($id, $name, $email, $role, $password);
    }

    private function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }
}
?>
