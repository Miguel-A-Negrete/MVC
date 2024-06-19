<?php
require_once "../conexion/DB.php";
class UserModel {
    private $pdo;


    public function __construct(){
        $this->pdo = new DB;
    }

     #Encuentra usuario por email o nombre
     public function findUserByEmailOrUsername($email, $name){
        $this->pdo->query('SELECT * FROM users WHERE name = :name OR email = :email');
        $this->pdo->bind(':name', $name);
        $this->pdo->bind(':email', $email);

        $row = $this->pdo->single();

        if($this->pdo->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    
     #Registro de usuarios
    public function register($data){
        $this->pdo->query('INSERT INTO users (id_user, name, email, rol, password_hash) VALUES (:id, :name, :email, :rol, :password_hash)');
        $this->pdo->bind(':id', $data['id_user']);
        $this->pdo->bind(':name', $data['name']);
        $this->pdo->bind(':email', $data['email']);
        $this->pdo->bind(':rol', $data['rol']);
        $this->pdo->bind(':password_hash', $data['password_hash']);

        if($this->pdo->execute()){
            return true;
        }else{
            return false;
        }
    }  

    #Login

    public function login($email, $password_hash){
        $row = $this->findUserByEmailOrUsername($email, $email);

        if($row == false) return false;

        $hashedPassword = $row->password_hash;
        if(password_verify($password_hash, $hashedPassword)){
            return $row;
        }else{
            return false;
        }
    }


   
}

    
?>
