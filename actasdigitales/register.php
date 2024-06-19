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
    <title>Registrate</title>   
    </head>
<body>

<section class="container">
    <header>Registrate</header>
    <?php flash('register') ?>
        <form class="form" method="post" action="./controladores/UsersController.php">

        <input type="hidden" name="type" value="register">

        <div class="input-box">
        <label for="name">Nombre completo</label>        
        <input type="text" name="name" 
        placeholder="nombre ">
        </div>

        <div class="input-box">
        <label for="email">Correo electronico</label>
        <input type="text" name="email" 
        placeholder="Email">
        </div>

        <div class="input-box">
        <label for="password">Contraseña</label>
        <input type="password" name="password_hash" 
        placeholder="******">
        </div>

        <div class="input-box">
        <label for="id_user">Número de identificación</label>
        <input type="text" name="id_user" 
        placeholder="id">
        </div>

        <label for="rol">Rol en el equipo</label>
            <div class="select-box">
            <select name="rol" id="rol">
            <option>Administrador</option>
            <option>Miembro</option>
            <option>Invitado</option>
            </select>
            </div>
        <button>Registrar</button>
    </form>
</section>
</body>
    
<?php 
?>