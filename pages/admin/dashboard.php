<?php
session_start();
require_once '../../utils/functions.php';
checkAuth();
checkAdminRole();

$stats = getDashboardStats();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Gestión de Árboles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('https://www.arenalobservatorylodge.com/wp-content/uploads/2023/01/Volcan-Arenal-4.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #e0e0e0;
        min-height: 100vh;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    h1 {
        color: #ffffff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        font-weight: 700;
        animation: fadeInDown 1s ease-out;
    }

    .card {
        background: rgba(45, 45, 45, 0.85);
        backdrop-filter: blur(10px);
        border: none !important;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 35px rgba(0, 0, 0, 0.5);
    }

    .card-body {
        color: #ffffff;
    }

    .card-title {
        color: #ffffff;
        font-weight: 600;
    }

    .text-primary {
        color: #a5aeff !important;
    }

    .text-success {
        color: #9aff9a !important;
    }

    .text-info {
        color: #9aecff !important;
    }

    .border-primary {
        border-color: rgba(165, 174, 255, 0.3) !important;
    }

    .border-success {
        border-color: rgba(154, 255, 154, 0.3) !important;
    }

    .border-info {
        border-color: rgba(154, 236, 255, 0.3) !important;
    }

    .display-4 {
        font-weight: 600;
        color: #ffffff;
    }

    .fs-5 {
        color: #e0e0e0;
    }

    a.text-decoration-none:hover .card {
        transform: translateY(-5px);
    }

    a.text-decoration-none .card-body {
        transition: background-color 0.3s ease;
    }

    a.text-decoration-none:hover .card-body {
        background-color: rgba(61, 61, 61, 0.9);
    }

    .page-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%);
        pointer-events: none;
        z-index: 0;
    }

    .container {
        position: relative;
        z-index: 1;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeIn 0.5s ease-out;
    }

    /* Navbar customization */
    .navbar {
        background: rgba(45, 45, 45, 0.9) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
    }

    .navbar-brand,
    .nav-link {
        color: #ffffff !important;
    }

    .nav-link:hover {
        color: #a5aeff !important;
    }
    </style>
</head>

<body>
    <div class="page-overlay"></div>
    <?php include '../../inc/adminNavbar.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Dashboard</h1>

        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card border-primary h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-people-fill text-primary fs-1"></i>
                        </h5>
                        <h2 class="display-4 mb-3"><?php echo $stats['amigos']; ?></h2>
                        <p class="card-text fs-5">Amigos Registrados</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-success h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-tree-fill text-success fs-1"></i>
                        </h5>
                        <h2 class="display-4 mb-3"><?php echo $stats['arboles_disponibles']; ?></h2>
                        <p class="card-text fs-5">Árboles Disponibles</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card border-info h-100">
                    <div class="card-body text-center">
                        <h5 class="card-title">
                            <i class="bi bi-cart-check-fill text-info fs-1"></i>
                        </h5>
                        <h2 class="display-4 mb-3"><?php echo $stats['arboles_vendidos']; ?></h2>
                        <p class="card-text fs-5">Árboles Vendidos</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h2 class="mb-4 text-white">Accesos Rápidos</h2>
            </div>

            <div class="col-md-3 mb-4">
                <a href="especies.php" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-tree text-success fs-1"></i>
                            <h5 class="card-title mt-3">Gestionar Especies</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-4">
                <a href="arboles.php" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-flower1 text-danger fs-1"></i>
                            <h5 class="card-title mt-3">Gestionar Árboles</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-4">
                <a href="amigos.php" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-people text-primary fs-1"></i>
                            <h5 class="card-title mt-3">Ver Amigos</h5>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-3 mb-4">
                <a href="HistorialActualizaciones.php" class="text-decoration-none">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-clock-history text-warning fs-1"></i>
                            <h5 class="card-title mt-3">Ver Actualizaciones</h5>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>