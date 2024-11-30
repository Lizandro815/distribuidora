<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Distribuidora</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg rounded w-100" id="login-card">
            <div class="card-body">
                <h3 class="text-center mb-4">Acceso a Distribuidora</h3>
                
                <?php
                if (isset($_GET['error'])) {
                    echo "<div class='alert alert-danger text-center'>" . htmlspecialchars($_GET['error']) . "</div>";
                }
                ?>

                <form id="loginForm" action="src/controllers/LoginController.php" method="POST">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingrese su correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                const correo = $('#correo').val();
                const contrasena = $('#contrasena').val();

                if (correo === "" || contrasena === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Por favor, complete todos los campos!',
                    });
                } else {
                    this.submit();
                }
            });
        });
    </script>
</body>
</html>
