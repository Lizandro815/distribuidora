<nav id="sidebar" class="bg-dark">
    <div class="user-info">
        <i class="fa fa-user"></i> <!-- Icono junto al nombre del usuario -->
        <span><?php echo htmlspecialchars($_SESSION['nombres']); ?></span>
    </div>
    <ul class="nav flex-column mt-2">
        <li class="nav-item">
            <a class="nav-link" href="#">
                <i class="fa fa-cog"></i> <span>Configuración</span>
            </a>
        </li>
        <li class="nav-item mt-4">
            <a class="nav-link" href="productos.php">
                <i class="fa fa-box"></i> <span>Productos</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <a class="nav-link" href="usuarios.php">
                <i class="fa fa-users"></i> <span>Usuarios</span>
            </a>
        </li>
    </ul>
</nav>
