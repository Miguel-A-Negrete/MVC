<?php
include_once './conexion/DB.php';
include_once './controladores/RecordsController.php';
include_once './modelos/RecordsModel.php';
include_once './controladores/UsersController.php';
include_once './modelos/UsersModel.php';
session_start();
if (isset($_SESSION['email'])) {
    $con = DB::getInstance();
    $recordController = new RecordController(new RecordModel($con));
    $userController = new UserController(new UserModel($con));

    $id = $userController->getUserID($_SESSION['email']);
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
        <title>Actas</title>
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
                    <li class="sidebar-list-item active">
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
                    <h2>ACTAS</h2>
                </div>

                <div class="main-button">
                    <button onclick="document.getElementById('modalForm').style.display='block'">Crear<svg
                            class="material-icons-outlined" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path
                                d="M256 80c0-17.7-14.3-32-32-32s-32 14.3-32 32V224H48c-17.7 0-32 14.3-32 32s14.3 32 32 32H192V432c0 17.7 14.3 32 32 32s32-14.3 32-32V288H400c17.7 0 32-14.3 32-32s-14.3-32-32-32H256V80z" />
                        </svg></button>
                </div>

                <div id="modalForm" class="modal">
                    <div class="modal-content">
                        <span class="close"
                            onclick="document.getElementById('modalForm').style.display='none'">&times;</span>
                        <form id="agregar-acta-form" action="index.php?route=records" method="post">
                            <div class="form-group">
                                <label for="asunto">Asunto:</label>
                                <input type="text" id="asunto" name="affair" class="form-control" required>
                            </div>
                            <input type="hidden" id="responsable" name="responsible" class="form-control"
                                value="<?php echo $id['id_user'] ?>">
                            <div class="form-group">
                                <label for="fecha">Fecha:</label>
                                <input type="date" id="fecha" name="date_record" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_inicio">Hora de Inicio:</label>
                                <input type="time" id="hora_inicio" name="start_time" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="hora_fin">Hora de Fin:</label>
                                <input type="time" id="hora_fin" name="end_time" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="privacidad">Privacidad:</label>
                                <select id="privacidad" name="privacy" class="form-control">
                                    <option value="Pública">Pública</option>
                                    <option value="Privada">Privada</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label para="relacion_acta">Relacionar con Acta:</label>
                                <select id="relacion_acta" name="relationship_record" class="form-control">
                                    <option value="">Ninguna</option>
                                    <?php
                                    $actas = $recordController->getAllRecords();
                                    foreach ($actas as $acta) {
                                        echo "<option value='" . $acta["id_record"] . "'>" . $acta["affair"] . " - Responsable: " . $acta["responsible"] . "</option>";
                                    }
                                    ?>
                                </select>

                            </div>
                            <button type="submit" class="btn btn-primary">Agregar Acta</button>
                        </form>
                    </div>
                </div>

                <div class="main-cards">
                    <?php
                    $actas = $recordController->getAllRecords();
                    $responsable = $userController->getUserByID($id['id_user']);
                    foreach ($actas as $acta) {
                        echo '<div class="card" data-meeting-id="' . $acta['id_record'] . '">
                            <div class="card-inner">
                                <div><h4>Nombre:</h4><h3>' . $acta['affair'] . '</h3></div>
                                <div><h4>Fecha:</h4><h4>' . $acta['date_record'] . '</h4></div>
                                <div><h4>Hora de inicio:</h4><h4>' . $acta['start_time'] . ' - ' . $acta['end_time'] . '</h4></div>
                                <h4>Responsable: ' . $responsable['name'] . '</h4>
                            </div>
                        </div>';
                    }


                    ?>

                </div>
            </main>
        </div>

        <!-- Scripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
        <script src="scripts.js"></script>
        <script>
            window.onclick = function (event) {
                var modal = document.getElementById('modalForm');
                if (event.target == modal) {
                    modal.style.display = "none";
                }
                var userSearchModal = document.getElementById('userSearchModal');
                if (event.target == userSearchModal) {
                    userSearchModal.style.display = "none";
                }
            }

            document.addEventListener('DOMContentLoaded', (event) => {
                // Asegúrate de que todos los elementos DOM estén cargados antes de agregar los event listeners
                document.querySelectorAll('.card').forEach(card => {
                    card.addEventListener('click', function () {
                        const meetingId = this.getAttribute('data-meeting-id');
                        openUserSearchModal(meetingId);
                    });
                });
            });

            function openUserSearchModal(meetingId) {
                document.getElementById('userSearchModal').style.display = 'block';
                // Almacenar el ID de la reunión para agregar participantes
                document.getElementById('userSearchModal').setAttribute('data-meeting-id', meetingId);
            }

            function searchUsers() {
                var input = document.getElementById('userSearch').value;
                var userList = document.getElementById('userList');
                userList.innerHTML = '';

                if (input.length > 2) {
                    fetch('index.php?route=participants&query=' + input)
                        .then(response => response.json())
                        .then(data => {
                            data.forEach(user => {
                                var li = document.createElement('li');
                                li.textContent = user.name + ' (' + user.email + ')';
                                li.setAttribute('data-user-id', user.id);
                                li.onclick = function () {
                                    selectUser(user.id, user.name, user.email);
                                };
                                userList.appendChild(li);
                            });
                        });
                }
            }

            function selectUser(userId, userName, userEmail) {
                var selectedUsers = document.getElementById('selectedUsers');
                var li = document.createElement('li');
                li.textContent = userName + ' (' + userEmail + ')';
                li.setAttribute('data-user-id', userId);
                selectedUsers.appendChild(li);
            }

            function addParticipant() {
                var selectedUsers = document.getElementById('selectedUsers').children;
                var meetingId = document.getElementById('userSearchModal').getAttribute('data-meeting-id');

                var userIds = [];
                for (var i = 0; i < selectedUsers.length; i++) {
                    userIds.push(selectedUsers[i].getAttribute('data-user-id'));
                }

                fetch('index.php?route=participants', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        meeting_id: meetingId,
                        user_ids: userIds
                    })
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Participantes agregados exitosamente.');
                            document.getElementById('userSearchModal').style.display = 'none';
                            location.reload();
                        } else {
                            alert('Hubo un error al agregar los participantes.');
                        }
                    });
            }

        </script>
    </body>

    </html>
    <?php
} else {
    header("Location: home.html");
}
?>
