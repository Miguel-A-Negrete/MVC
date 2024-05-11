<?php

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
        $username = isset($_POST['username']) ? $_POST['username'] : null;
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        $userId = isset($_POST['id_user']) ? $_POST['id_user'] : null;
        $name = isset($_POST['name']) ? $_POST['name'] : null;
        $role = isset($_POST['rol']) ? $_POST['rol'] : null;

        if ($username !== null && $password !== null && $userId !== null) {
            $result = $this->createUser($userId, $name, $username, $role, $password);
            if ($result > 0) {
                session_start();
                $_SESSION['email'] = $username;
                return ['success' => true, 'redirect' => 'home.html'];
            } else {
                return ['error' => 'Registro inválido.'];
            }
        }

        if ($username !== null && $password !== null) {
            $result = $this->getUserApprobation($username, $password);
            if ($result) {
                session_start();
                $_SESSION['email'] = $username;
                return ['success' => true, 'redirect' => 'actas.php'];
            } else {
                return ['error' => 'Credenciales inválidas.'];
            }
        }
    }

    private function handlePUT() {
        parse_str(file_get_contents("php://input"), $_PUT);
        $id = isset($_PUT['id_user']) ? $_PUT['id_user'] : null;
        $name = isset($_PUT['name']) ? $_PUT['name'] : null;
        $email = isset($_PUT['email']) ? $_PUT['email'] : null;
        $role = isset($_PUT['rol']) ? $_PUT['rol'] : null;
        $password = isset($_PUT['password']) ? $_PUT['password'] : null;
        $result = $this->updateUser($id, $name, $email, $role, $password);
        return ['success' => $result > 0];
    }

    private function handleDELETE() {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $id = isset($_DELETE['id_user']) ? $_DELETE['id_user'] : null;
        $result = $this->deleteUser($id);
        return ['success' => $result > 0];
    }

    private function createUser($id, $name, $email, $role, $password) {
        return $this->userModel->createUser($id, $name, $email, $role, $password);
    }

    private function getAllUsers() {
        return $this->userModel->getAllUsers();
    }

    private function getUserByID($id) {
        return $this->userModel->getUserByID($id);
    }

    private function getUserApprobation($email, $password) {
        return $this->userModel->getUserApprobation($email, $password);
    }

    private function updateUser($id, $name, $email, $role, $password) {
        return $this->userModel->updateUser($id, $name, $email, $role, $password);
    }

    private function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }
}

?>