
<?php 
    include_once './conexion/session_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="./CSS/style.css">
<link rel="stylesheet" href="./CSS/styleHome.css">
<script src="./JS/login.js"></script>
</head>
<body>
<section class="container">
<header>Iniciar sesión</header>
<?php flash('login') ?>
<form id="loginForm" class="form" method="post" action="./controladores/UsersController.php">
    <input type="hidden" name="type" value="login">
        <div class="input-box">
        <label for="email">email</label>
        <input type="text" name="email"  
        placeholder="Email">
        </div>

        <div class="input-box">
        <label for="password">Contraseña</label>
        <input type="password" name="password_hash" 
        placeholder="Password">
        </div>

        <button type="submit" name="submit">Log In</button>
    </form>

    <p>¿No tienes cuenta? <a href="register.php">Regístrate aquí</a></p>
    
<?php 
?>