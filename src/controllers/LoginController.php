<?php
require_once __DIR__ . '/../config/config.php'; // Incluir configuración de la base de datos

class LoginController {
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

    public function login($correo, $contrasena) {
        $sql = "SELECT * FROM usuarios WHERE correo = :correo";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
            session_start();
            $_SESSION['usuario_id'] = $usuario['id_usuario'];  // Asegúrate de que es 'id_usuario'
            $_SESSION['nombres'] = $usuario['nombres'];
            $_SESSION['rol_id'] = $usuario['id_rol'];

            // Redirigir al dashboard
            header("Location: ../../user_dashboard.php");
            exit();
        } else {
            header("Location: ../../index.php?error=Credenciales incorrectas");
            exit();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $loginController = new LoginController();
    $loginController->login($correo, $contrasena);
}
?>
