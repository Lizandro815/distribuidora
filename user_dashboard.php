<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Incluir el DashboardController
require_once 'src/controllers/DashboardController.php';

// Obtener la información del usuario desde la sesión
$usuario_id = $_SESSION['usuario_id']; 
$nombres = $_SESSION['nombres'];
$rol_id = $_SESSION['rol_id'];

// Crear una instancia del controlador
$dashboardController = new DashboardController();

// Obtener la información del usuario desde el controlador
$usuario = $dashboardController->obtenerUsuarioPorId($usuario_id);

// Obtener el rol del usuario desde el controlador
$rol = $dashboardController->obtenerRolPorId($rol_id);

// Obtener el mensaje de bienvenida
$mensaje_bienvenida = $dashboardController->obtenerMensajeBienvenida($rol, $nombres);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Distribuidora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet"> <!-- Para los íconos -->
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        #sidebar {
            height: 100%;
            background-color: #343a40;
            padding: 1rem;
            color: white;
            width: 250px;
            position: fixed;
            z-index: 1000;
        }

        #sidebar .nav-link {
            color: white;
            display: flex;
            align-items: center;
        }

        #sidebar .nav-link i {
            margin-right: 10px;
        }

        #sidebar .nav-link:hover {
            background-color: #495057;
        }

        #sidebar .user-info {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        #sidebar .user-info i {
            margin-right: 10px;
        }

        /* Estilos para el contenido principal */
        #main-content {
            margin-left: 250px;
            padding: 20px;
            width: calc(100% - 250px);
        }

        h1 {
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <!-- Incluir la barra de navegación -->
    <?php include __DIR__ . '/includes/navegacion.php'; ?>

    <!-- Contenido Principal -->
    <div id="main-content" class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center"><?php echo htmlspecialchars($mensaje_bienvenida); ?></h1>
                <div class="text-center mt-4">
                    <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
