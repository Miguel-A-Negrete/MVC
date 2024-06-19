<?php 
    include_once './conexion/session_helper.php';
    include_once './views/header.php'
?>
?>

<h1 class="header">Registro</h1>

<?php flash('register') ?>

<form method="post" action="./controladores/UsersController.php">
    <input type="hidden" name="type" value="register">
    <input type="text" name="name" 
    placeholder="Full name...">
    <input type="text" name="email" 
    placeholder="Email...">
    <input type="text" name="id_user" 
    placeholder="id...">
    <input type="password" name="password_hash" 
    placeholder="Password...">
    <input type="rol" name="rol" 
    placeholder="Rol">
    <button type="submit" name="submit">Sign Up</button>
</form>

<?php 
?>