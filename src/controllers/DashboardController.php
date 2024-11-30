<?php
require_once __DIR__ . '/../config/config.php'; // Incluir configuración de la base de datos

class DashboardController {
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

    // Obtener información del usuario por ID
    public function obtenerUsuarioPorId($usuario_id) {
        $sql = "SELECT * FROM usuarios WHERE id_usuario = :usuario_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener el nombre del rol por ID de rol
    public function obtenerRolPorId($rol_id) {
        $sql = "SELECT nombre FROM roles WHERE id_rol = :id_rol";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id_rol', $rol_id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['nombre'];
    }

    // Definir el mensaje de bienvenida según el rol
    public function obtenerMensajeBienvenida($rol, $nombres) {
        if ($rol == 'administrador') {
            return "Bienvenido, Administrador $nombres! Tienes acceso completo al sistema.";
        } elseif ($rol == 'empleados') {
            return "Bienvenido, $nombres! Puedes realizar tus tareas asignadas.";
        } else {
            return "Bienvenido, $nombres!";
        }
    }
}
?>
