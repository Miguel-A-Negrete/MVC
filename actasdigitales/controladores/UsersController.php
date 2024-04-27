<?php
class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function createUser($name, $email, $rol, $password) {
        return $this->userModel->createUser($name, $email, $rol, $password);
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();
    }
    public function getUserByID($id) {
        return $this->userModel->getUserByUsername($id);
    }

    public function updateUser($id, $name, $email, $role, $password) {
        return $this->userModel->updateUserPassword($id, $name, $email, $role, $password);
    }

    public function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }
}
?>