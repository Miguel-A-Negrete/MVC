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
                    <h1><?= count($actas); ?></h1>
                </a>
                <a class="card" href="reuniones.php">
                    <div class="card-inner">
                        <h3>REUNIONES</h3>
                        <span class="material-icons-outlined">camera</span>
                    </div>
                    <h1><?= count($reuniones); ?></h1>
                </a>
                <div class="card">
                    <div class="card-inner">
                        <h3>USUARIOS</h3>
                        <span class="material-icons-outlined">groups</span>
                    </div>
                    <h1><?= count($usuarios); ?></h1>
                </div>
            </div>
            <div class="charts">
                <div class="card-inner">
                    <h3>Participantes por Reunión</h3>
                    <canvas id="participantsChart"></canvas>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
