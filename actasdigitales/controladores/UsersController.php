<?php
class UserController {
    private $userModel;

    public function __construct($userModel) {
        $this->userModel = $userModel;
    }

    public function createUser($id,$name, $email, $role, $password) {
        return $this->userModel->createUser($id,$name, $email, $role, $password);
    }

    public function getAllUsers() {
    return $this->userModel->getAllUsers();
    }

    public function getUserByID($id) {
        return $this->userModel->getUserByID($id);
    }

    public function getUserApprobation($email, $password){
        return $this->userModel->getUserApprobation($email, $password);
    }

    public function updateUser($id, $name, $email, $role, $password) {
        return $this->userModel->updateUser($id, $name, $email, $role, $password);
    }

    public function deleteUser($id) {
        return $this->userModel->deleteUser($id);
    }
}
?>
