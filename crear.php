<?php
// Incluir la configuración de la base de datos
require_once 'src/config/config.php';

// Iniciar sesión
session_start();

// Verificar si ya existe un administrador en la base de datos
$sql = "SELECT * FROM usuarios WHERE correo = :correo";
$stmt = $conn->prepare($sql);
$admin_email = 'admin@example.com';
$stmt->bindParam(':correo', $admin_email);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    // Si el administrador ya está registrado, redirigir al dashboard
    header("Location: user_dashboard.php");
    exit();
} else {
    // Crear un nuevo administrador
    $nombres = 'Admin';
    $apellido_paterno = 'Principal';
    $apellido_materno = 'User';
    $telefono = '5551234567';
    $correo = $admin_email;
    $contrasena = password_hash('adminpassword', PASSWORD_BCRYPT);
    $id_rol = 1; // Suponiendo que 1 es el ID del rol 'administrador'

    // Preparar la inserción
    $sql = "INSERT INTO usuarios (nombres, apellido_paterno, apellido_materno, telefono, correo, contrasena, id_rol) 
            VALUES (:nombres, :apellido_paterno, :apellido_materno, :telefono, :correo, :contrasena, :id_rol)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nombres', $nombres);
    $stmt->bindParam(':apellido_paterno', $apellido_paterno);
    $stmt->bindParam(':apellido_materno', $apellido_materno);
    $stmt->bindParam(':telefono', $telefono);
    $stmt->bindParam(':correo', $correo);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':id_rol', $id_rol);

    // Ejecutar la inserción
    if ($stmt->execute()) {
        // Establecer variables de sesión
        $_SESSION['usuario_id'] = $conn->lastInsertId();
        $_SESSION['nombres'] = $nombres;
        $_SESSION['rol_id'] = $id_rol;

        // Redirigir al dashboard
        header("Location: user_dashboard.php");
        exit();
    } else {
        echo "Error al crear el administrador: " . $stmt->errorInfo()[2];
    }
}
?>
