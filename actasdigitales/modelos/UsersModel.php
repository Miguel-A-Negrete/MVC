<?php
class UserModel {
    private $pdo;
    private $tableName = 'users';

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($id, $name, $email, $role, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $query = "INSERT INTO users (id_user,name, email, rol, password_hash) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id, $name, $email, $role, $hashedPassword]);
        return $stmt->rowCount(); 
    }
    
    public function getAllUsers() {
        $query = "SELECT id_user, name, email, rol,password_hash FROM users";
        $stmt = $this->pdo->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserByID($id) {
        $query = "SELECT id_user, name, email, rol,password_hash FROM users WHERE id_user = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    public function getSearchUser(){
        if (isset($_GET['query'])) {
        $query = $_GET['query'];
        $con = DB::getInstance();
        $stmt = $con->prepare("SELECT id, name, email FROM users WHERE name LIKE ? OR email LIKE ?");
        $stmt->execute(['%' . $query . '%', '%' . $query . '%']);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        echo json_encode($results);
    }
    }
    

    public function getUserApprobation($email, $password) {
        // Consulta solo el hash de la contraseña asociado con el correo electrónico
        $query = "SELECT password_hash FROM {$this->tableName} WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        
        // Verifica si el correo electrónico existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Usa password_verify para comparar la contraseña proporcionada con el hash almacenado
            if (password_verify($password, $user['password_hash'])) {
                return true; // Las credenciales son válidas
            }
        }
    
        return false; // Las credenciales son inválidas
    }

    public function getUserID($email){
        $query = "SELECT id_user FROM {$this->tableName} WHERE email = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    

    public function updateUser($id, $name, $email, $role, $password) {
        $hashedPassword = ($password != null) ? password_hash($password, PASSWORD_BCRYPT) : null;

        $query = "UPDATE users SET name = ?, email = ?, rol = ?";
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
        $query = "DELETE FROM users WHERE id_user = ?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$id]);
        return $stmt->rowCount(); 
    }
}
?>
