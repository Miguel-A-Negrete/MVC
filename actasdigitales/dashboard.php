<?php
require_once './modelos/UsersModel.php';
require_once './modelos/RecordsModel.php';
require_once './modelos/MeetingsModel.php';
require_once './controladores/UsersController.php';
require_once './controladores/RecordsController.php';
require_once './controladores/MeetingsController.php';
require_once './conexion/Jwt.php';
require_once './conexion/Conexion.php';
require_once './vendor/autoload.php';

use \Firebase\JWT\JWT;

// Verificar la presencia del token en la cabecera HTTP
if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
    header('Location: home.html');
    exit();
}

$authHeader = $_SERVER['HTTP_AUTHORIZATION'];
list($jwt) = sscanf($authHeader, 'Bearer %s');

if (!$jwt) {
    header('Location: home.html');
    exit();
}

// Verificar y decodificar el token
try {
    $decoded = JWT::decode($jwt, Config::SECRET_KEY, array('HS256'));
    // Si el token es válido, continuar con la ejecución del script
} catch (Exception $e) {
    header('Location: home.html');
    exit();
}
    $con = DB::getInstance();
    $recordController = new RecordController(new RecordModel($con));
    $meetingController = new MeetingController(new MeetingModel($con));
    $userController = new UserController(new UserModel($con)); 
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Dashboard</title>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="./CSS/style.css">
        <link rel="stylesheet" href="./CSS/normalize.css">
    </head>

    <body>
        <div class="grid-container">

            <header class="header">
                <div class="menu-icon" onclick="openSidebar()">
                    <span class="material-icons-outlined">menu</span>
                </div>
                <div></div>
                <div class="header-right">
                    <span class="material-icons-outlined">notifications</span>
                    <span class="material-icons-outlined">email</span>
                    <span class="material-icons-outlined">account_circle</span>
                </div>
            </header>
            <aside id="sidebar">
                <div class="sidebar-title">
                    <div class="sidebar-brand">
                        <span class="material-icons-outlined"></span> Sistemas
                    </div>
                    <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
                </div>

                <ul class="sidebar-list">
                    <li class="sidebar-list-item active">
                        <a href="dashboard.php">
                            <span class="material-icons-outlined">dashboard</span> Panel
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="#" target="_blank">
                            <span class="material-icons-outlined">poll</span> Resumen
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="#" target="_blank">
                            <span class="material-icons-outlined">groups</span> Usuarios
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="actas.php">
                            <span class="material-icons-outlined">fact_check</span> Actas
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="reuniones.php">
                            <span class="material-icons-outlined">camera</span> Reuniones
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="#" target="_blank">
                            <span class="material-icons-outlined">settings</span> Configuracion
                        </a>
                    </li>
                </ul>
            </aside>
            <main class="main-container">
                <div class="main-tittle">
                    <h2>PANEL</h2>
                </div>

                <div class="main-cards">

                    <a class="card" href="actas.php">
                        <div class="card-inner">
                            <h3>ACTAS</h3>
                            <span class="material-icons-outlined">fact_check</span>
                        </div>
                        <?php
                        $actas = $recordController->getAllRecords();
                        $tamano = count($actas);
                        echo "<h1>" . $tamano . "</h1>";
                        ?>
                    </a>

                    <a class="card" href="reuniones.php">
                        <div class="card-inner">
                            <h3>REUNIONES</h3>
                            <span class="material-icons-outlined">camera</span>
                        </div>
                        <?php
                        $reuniones = $meetingController->getAllMeetings();
                        $tamano = count($reuniones);
                        echo "<h1>" . $tamano . "</h1>";
                        ?>
                    </a>

                    <div class="card">
                        <div class="card-inner">
                            <h3>USUARIOS</h3>
                            <span class="material-icons-outlined">groups</span>
                        </div>
                        <?php
                        $usuarios = $userController->getAllUsers();
                        $tamano = count($usuarios);
                        echo "<h1>" . $tamano . "</h1>";
                        ?>
                    </div>

                </div>

                <div class="charts">
                    <div class="card-inner">
                        <h3>Participantes por Reunión </h3>
                        <canvas id="participantsChart"></canvas>
                    </div>
                </div>
            </main>
        </div>
<!---
             Área para mostrar las actas existentes
            <div class="container mt-5">
                <h1>Lista de Actas</h1>

                <?php if (empty($actas)) { ?>
                    <p>No se encontraron actas.</p>
                <?php } else { ?>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Fecha</th>
                                <th>Hora de Inicio</th>
                                <th>Hora de Fin</th>
                                <th>Asunto</th>
                                <th>Responsable</th>
                                <th>Privacidad</th>
                                <th>Relación</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($actas as $acta) { ?>
                                <tr>
                                    <td><?php echo $acta['id_record']; ?></td>
                                    <td><?php echo $acta['date_record']; ?></td>
                                    <td><?php echo $acta['start_time']; ?></td>
                                    <td><?php echo $acta['end_time']; ?></td>
                                    <td><?php echo $acta['affair']; ?></td>
                                    <td><?php echo $acta['responsible']; ?></td>
                                    <td><?php echo $acta['privacy']; ?></td>
                                    <td><?php echo isset($acta['relationship_record']) ? $acta['relationship_record'] : 'Ninguna'; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div> -->

        <!-- JavaScript para manejar formularios y solicitudes AJAX -->
        <script>
            // Manejo de formulario para agregar una nueva acta
            $('#agregar-acta-form').submit(function (event) {
                event.preventDefault(); // Evitar la recarga de la página

                const datos = {
                    asunto: $('#asunto').val(),
                    responsable: $('#responsable').val(),
                    fecha: $('#fecha').val(),
                    hora_inicio: $('#hora_inicio').val(),
                    hora_fin: $('#hora_fin').val(),
                    privacidad: $('#privacidad').val(),
                    relacion_acta: $('#relacion_acta').val(),
                };

                // Enviar datos a través de AJAX al archivo PHP
                $.post('index.php', datos, function (response) {
                    alert(response); // Mostrar el resultado
                });
            });
        </script>
        </div>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
        <script src="./JS/reuniones.js"></script>
    </body>

    </html>