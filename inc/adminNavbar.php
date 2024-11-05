<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard.php">Sistema de Gestión de Árboles</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php $current_page = basename($_SERVER['PHP_SELF']); ?>
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>"
                        href="dashboard.php">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'especies.php' ? 'active' : ''; ?>"
                        href="especies.php">
                        <i class="bi bi-tree"></i> Especies
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'amigos.php' ? 'active' : ''; ?>" href="amigos.php">
                        <i class="bi bi-people"></i> Amigos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo $current_page == 'arboles.php' ? 'active' : ''; ?>"
                        href="arboles.php">
                        <i class="bi bi-flower1"></i> Árboles
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link text-light">
                        <i class="bi bi-person"></i> <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../actions/logout.php">
                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>