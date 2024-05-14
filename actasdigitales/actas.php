<?php
include_once './conexion/DB.php';
include_once './controladores/RecordsController.php';
include_once './modelos/RecordsModel.php';
session_start();
if (isset($_SESSION['email'])) {
    $con = DB::getInstance();
    $recordController = new RecordController(new RecordModel($con));
    ?>
    <!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
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
                    <h2>PANEL</h2>
                </div>

                <div class="main-cards">

                <div class="card">
                    <div class="card-inner">
                        <h3>ACTAS</h3>
                        <span class="material-icons-outlined">fact_check</span>
                    </div>
                    <?php
                    $actas = $recordController->getAllRecords(); 
                    $tamano = count($actas);
                    echo "<h1>".$tamano."</h1>";
                    ?>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>REUNIONES</h3>
                        <span class="material-icons-outlined">camera</span>
                    </div>
                    <?php
                    $actas = $recordController->getAllRecords(); 
                    $tamano = count($actas);
                    echo "<h1>".$tamano."</h1>";
                    ?>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>USUARIOS</h3>
                        <span class="material-icons-outlined">groups</span>
                    </div>
                    <?php
                    $actas = $recordController->getAllRecords(); 
                    $tamano = count($actas);
                    echo "<h1>".$tamano."</h1>";
                    ?>
                </div>

                <div class="card">
                    <div class="card-inner">
                        <h3>ALERTAS</h3>
                        <span class="material-icons-outlined">notifications</span>
                    </div>
                    <?php
                    $actas = $recordController->getAllRecords(); 
                    $tamano = count($actas);
                    echo "<h1>".$tamano."</h1>";
                    ?>
                </div>

                </div>

                <div class="charts">

                    <div class="charts-card">
                        <h2 class="charts-title">Las 5 mejores actas</h2>
                        <div id="bar-chart"></div>
                    </div>

                    <div class="charts-card">
                        <h2 class="charts-title">Participantes por reunion</h2>
                        <div id="area-chart"></div>
                    </div>

                </div>
            </main>
            </div>
            <!-- <h1>Gestión de Actas</h1>

             Formulario para agregar una nueva acta
            <h2>Agregar Acta</h2>
            <form id="agregar-acta-form">
                <div class="form-group">
                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="responsable">Responsable (ID):</label>
                    <input type="number" id="responsable" name="responsable" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="fecha">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="hora_inicio">Hora de Inicio:</label>
                    <input type="time" id="hora_inicio" name="hora_inicio" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="hora_fin">Hora de Fin:</label>
                    <input type="time" id="hora_fin" name="hora_fin" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="privacidad">Privacidad:</label>
                    <select id="privacidad" name="privacidad" class="form-control">
                        <option value="Pública">Pública</option>
                        <option value="Privada">Privada</option>
                    </select>
                </div>
                 Campo para establecer la relación entre actas 
                <div class="form-group">
                    <label para="relacion_acta">Relacionar con Acta:</label>
                    <select id="relacion_acta" name="relacion_acta" class="form-control">
                        <option value="">Ninguna</option>
                        <?php
                        $actas = $recordController->getAllRecords();
                        // Agregar opciones de actas existentes
                        foreach ($actas as $acta) {
                            echo "<option value='" . $acta["id_record"] . "'>" . $acta["affair"] . " - Responsable: " . $acta["responsible"] . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Agregar Acta</button>
            </form>

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
        <script src="scripts.js"></script>
    </body>

    </html>

    <?php
} else {
    header("Location: home.html");
}
?>
