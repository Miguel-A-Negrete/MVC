<?php
include_once './conexion/DB.php';
include_once './controladores/MeetingsController.php';
include_once './modelos/MeetingsModel.php';
include_once './controladores/ParticipantsController.php';
include_once './modelos/ParticipantsModel.php';
session_start();
if (isset($_SESSION['email'])) {
    $con = DB::getInstance();
    $meetingController = new MeetingController(new MeetingModel($con));
    $participantController = new ParticipantController(new ParticipantModel($con));
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
        <link rel="stylesheet" href="./CSS/normalize.css">
        <link rel="stylesheet" href="./CSS/style.css">
        <title>Reuniones</title>
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
        <li class="sidebar-list-item">
            <a href="#" target="_blank">
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
            <a href="#" target="_blank">
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
        <h2>REUNIONES</h2>
    </div>

    <div class="main-button">
        <button onclick="document.getElementById('modalForm').style.display='block'">Crear<svg class="material-icons-outlined" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z"/></svg></button>
    </div>

    <div id="modalForm" class="modal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('modalForm').style.display='none'">&times;</span>
            <form action="index.php?route=meetings" method="POST">
                <label for="title">Título:</label>
                <input type="text" id="title" name="title" required>
                
                <label for="date">Fecha:</label>
                <input type="date" id="date" name="date" required>
                
                <label for="start_time">Hora de inicio:</label>
                <input type="time" id="start_time" name="start_time" required>
                
                <label for="end_time">Hora de fin:</label>
                <input type="time" id="end_time" name="end_time" required>
                
                <button type="submit">Guardar</button>
            </form>
        </div>
    </div>

    <div class="main-cards">
    <?php
$reuniones = $meetingController->getAllMeetings();

// Obtener participantes para todas las reuniones de una vez
$participantes_por_reunion = [];
foreach ($reuniones as $reunion) {
    $participantes_por_reunion[$reunion['meeting_id']] = $participantController->getParticipantByID($reunion['meeting_id']);
}

// Mostrar las reuniones y sus participantes
foreach ($reuniones as $reunion) {
    $participantes = $participantes_por_reunion[$reunion['meeting_id']];
    $tamano = count($participantes);
    echo '<div class="card">
            <div class="card-inner">
                <div><h4>Nombre:</h4><h3>'.$reunion['title'].'</h3></div>
                <div><h4>Fecha:</h4><h4>'.$reunion['date'].'</h4></div>
                <div><h4>Hora de inicio:</h4><h4>'.$reunion['start_time'].' - '.$reunion['end_time'].'</h4></div>
                <h4>Participantes: '.$tamano.'</h4>
            </div>
        </div>';
}
?>

    </div>
</main>
</div>
</div>

<!-- Scripts -->
<script>
window.onclick = function(event) {
    var modal = document.getElementById('modalForm');
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
<script src="scripts.js"></script>
    </body>
    </html>
    <?php
} else{
    header("Location: home.html");
}

?>