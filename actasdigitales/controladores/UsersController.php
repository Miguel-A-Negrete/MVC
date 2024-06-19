<?php

    require_once '../modelos/UsersModel.php';
    require_once '../conexion/session_helper.php';
    require_once '../conexion/Conexion.php';
    require_once '../conexion/Jwt.php';

    class Users {

        private $userModel;
        private $jwt;

        
        public function __construct(){
            $this->userModel = new UserModel;
            $this->jwt = new Jwt(Config::SECRET_KEY);
        }

        public function register(){
            //Process form
            
            //Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            //Init data
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'id_user' => trim($_POST['id_user']),
                'password_hash' => trim($_POST['password_hash']),
                'rol' => trim($_POST['rol'])
            ];

            //Validate inputs
            if(empty($data['name']) || empty($data['email']) || empty($data['id_user']) || 
            empty($data['password_hash'])){
                flash("register", "Please fill out all inputs");
                redirect("../register.php");
            }

            if(!preg_match("/^[0-9]*$/", $data['id_user'])){
                flash("register", "Invalid id");
                redirect("../register.php");
            }

            if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                flash("register", "Invalid email");
                redirect("../register.php");
            }

            if(strlen($data['password_hash']) < 6){
                flash("register", "Invalid password");
                redirect("../register.php");
            }

            //User with the same email or password already exists
            if($this->userModel->findUserByEmailOrUsername($data['email'], $data['name'])){
                flash("register", "Username or email already taken");
                redirect("../register.php");
            }

            //Passed all validation checks.
            //Now going to hash password
            $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_DEFAULT);

            //Register User
            if($this->userModel->register($data)){
                redirect("../login.php");
            }else{
                die("Something went wrong");
            }
        }

        public function login(){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password_hash' => trim($_POST['password_hash'])
            ];
        
            if (empty($data['email']) || empty($data['password_hash'])) {
                flash("login", "Please fill out all inputs");
                header("location: ../login.php");
                exit();
            }
        
            $user = $this->userModel->login($data['email'], $data['password_hash']);

    if (!$user) {
        http_response_code(401); // Unauthorized
        echo json_encode(array("message" => "Invalid credentials"));
        exit();
    }

    $payload = [
        "id_user" => $user->id_user,
        "name" => $user->name, // Include name in JWT payload
        "email" => $user->email,
    ];
    $token = $this->jwt->encode($payload);

    http_response_code(200); // OK
    echo json_encode(array("token" => $token));
    }
    }

    $init = new Users;

    //Ensure that user is sending a post request
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        switch($_POST['type']){
            case 'register':
                $init->register();
                break;
            case 'login':
                $init->login();
                break;
            default:
            redirect("../index.php");
        }
        
    }else{
            redirect("../index.php");
        }

    