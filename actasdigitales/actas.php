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
        <title>Gestión de Actas</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>

    <body>
        <div class="container mt-5">
            <h1>Gestión de Actas</h1>

            <!-- Formulario para agregar una nueva acta -->
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
                <!-- Campo para establecer la relación entre actas -->
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

            <!-- Área para mostrar las actas existentes -->
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
            </div>

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
    </body>

    </html>

    <?php
} else {
    header("Location: home.html");
}
?>
