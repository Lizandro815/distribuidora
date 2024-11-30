<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Incluir el archivo de configuración de la base de datos
require_once __DIR__ . '/src/config/config.php';

// Incluir el controlador de usuarios
require_once 'src/controllers/UsuariosController.php';

// Crear una instancia del controlador de usuarios
$usuariosController = new UsuariosController();
$usuarios = $usuariosController->obtenerTodosLosUsuarios();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios | Distribuidora</title>
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

    <!-- Contenido principal -->
    <div id="main-content" class="container mt-5">
        <h1 class="mb-4">Lista de Usuarios</h1>

        <!-- Tabla de usuarios -->
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombres</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['id_usuario']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombres']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido_paterno']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['apellido_materno']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['nombre_rol']); ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-edit"></i> Editar
                            </a>
                            <a href="eliminar_usuario.php?id=<?php echo $usuario['id_usuario']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">
                                <i class="fa fa-trash"></i> Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Botón para agregar nuevo usuario -->
        <a href="agregar_usuario.php" class="btn btn-success">
            <i class="fa fa-user-plus"></i> Agregar Usuario
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
