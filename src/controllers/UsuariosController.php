<?php
require_once __DIR__ . '/../config/config.php'; // Incluir configuración de la base de datos

class UsuariosController {
    private $conn;

    public function __construct() {
        global $host, $dbname, $username, $password;
        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            die("Error de conexión: " . $exception->getMessage());
        }
    }

    // Obtener todos los usuarios
    public function obtenerTodosLosUsuarios() {
        try {
            $sql = "SELECT u.id_usuario, u.nombres, u.apellido_paterno, u.apellido_materno, u.telefono, u.correo, r.nombre AS nombre_rol
                    FROM usuarios u
                    INNER JOIN roles r ON u.id_rol = r.id_rol";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0); // Registrar errores sin exponerlos al usuario
            return [];
        }
    }

    // Obtener un usuario por su ID
    public function obtenerUsuarioPorId($id_usuario) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            return null;
        }
    }

    // Agregar un nuevo usuario
    public function agregarUsuario($nombres, $apellido_paterno, $apellido_materno, $telefono, $correo, $contrasena, $id_rol) {
        try {
            $sql = "INSERT INTO usuarios (nombres, apellido_paterno, apellido_materno, telefono, correo, contrasena, id_rol)
                    VALUES (:nombres, :apellido_paterno, :apellido_materno, :telefono, :correo, :contrasena, :id_rol)";
            $stmt = $this->conn->prepare($sql);

            // Encriptar la contraseña antes de guardarla
            $contrasena_hash = password_hash($contrasena, PASSWORD_BCRYPT);

            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellido_paterno', $apellido_paterno);
            $stmt->bindParam(':apellido_materno', $apellido_materno);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':contrasena', $contrasena_hash);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            return false;
        }
    }

    // Editar un usuario existente
    public function editarUsuario($id_usuario, $nombres, $apellido_paterno, $apellido_materno, $telefono, $correo, $id_rol) {
        try {
            $sql = "UPDATE usuarios 
                    SET nombres = :nombres, apellido_paterno = :apellido_paterno, apellido_materno = :apellido_materno, 
                        telefono = :telefono, correo = :correo, id_rol = :id_rol 
                    WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':nombres', $nombres);
            $stmt->bindParam(':apellido_paterno', $apellido_paterno);
            $stmt->bindParam(':apellido_materno', $apellido_materno);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            return false;
        }
    }

    // Eliminar un usuario por su ID
    public function eliminarUsuario($id_usuario) {
        try {
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log($e->getMessage(), 0);
            return false;
        }
    }

    // Cerrar la conexión
    public function __destruct() {
        $this->conn = null;
    }
}
?>
