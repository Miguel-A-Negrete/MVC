<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($name, $email, $rol, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO usuarios (name, email, rol, password_hash) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$name, $email, $rol, $hashedPassword]);
        return $stmt->rowCount(); 
    }
    
    public function getAllUsers() {
        $query = "SELECT id_user, name, email, rol FROM users";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByID($id) {
        $query = "SELECT * FROM usuarios WHERE id_user = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function updateUser($id, $name, $email, $role, $password) {
        $hashedPassword = ($password != null) ? password_hash($password, PASSWORD_BCRYPT) : null;

        $query = "UPDATE usuarios SET name = ?, email = ?, rol = ?";
        $params = [$name, $email, $role];

        if ($hashedPassword != null) {
            $query .= ", password_hash = ?";
            $params[] = $hashedPassword;
        }

        $query .= " WHERE id_user = ?";
        $params[] = $id;

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function deleteUser($id) {
        $query = "DELETE FROM usuarios WHERE id_user = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); 
    }
}
?>