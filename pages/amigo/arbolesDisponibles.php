<?php
session_start();
require_once '../../utils/functions.php';
checkAuth();

if ($_SESSION['rol_id'] != 2) {
    header('Location: unauthorized.php');
    exit();
}

$trees = getAllTrees();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Árboles Disponibles - Sistema de Gestión de Árboles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)),
            url('https://www.arenalobservatorylodge.com/wp-content/uploads/2023/01/Volcan-Arenal-4.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #e0e0e0;
        min-height: 100vh;
    }

    .container {
        padding-top: 2rem;
        padding-bottom: 2rem;
    }

    .card {
        background: rgba(45, 45, 45, 0.85);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .card-body {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-title {
        color: #ffffff;
        font-weight: 600;
    }

    .card-text {
        color: #e0e0e0;
    }

    .card-footer {
        background-color: transparent;
        border-top: none;
        border-bottom-left-radius: 15px;
        border-bottom-right-radius: 15px;
    }

    .btn-details {
        background-color: rgba(45, 45, 45, 0.85);
        color: #ffffff;
        border: none;
        border-radius: 5px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-details:hover {
        background-color: rgba(55, 55, 55, 0.95);
        transform: translateY(-2px);
    }

    .page-header {
        background: rgba(45, 45, 45, 0.85);
        backdrop-filter: blur(10px);
        padding: 1.5rem;
        border-radius: 15px;
        margin-bottom: 2rem;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
    }

    .page-header h2 {
        color: #ffffff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        margin: 0;
    }

    .btn-back {
        color: #fff;
        background-color: #0d6efd;
        border-color: #0d6efd;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-right: 1rem;
        font-weight: 500;
    }

    .btn-back:hover {
        background-color: #0b5ed7;
        border-color: #0a58ca;
        color: #fff;
        transform: translateY(-2px);
    }

    .alert {
        border-radius: 10px;
        border: none;
    }

    .alert-success {
        background-color: rgba(28, 74, 28, 0.9);
        border-color: rgba(39, 105, 39, 0.5);
        color: #9aff9a;
    }

    .alert-info {
        background-color: rgba(23, 64, 97, 0.9);
        border-color: rgba(40, 94, 133, 0.5);
        color: #b6d8ef;
    }

    .bi {
        margin-right: 0.25rem;
    }

    em {
        color: #a5aeff;
    }

    .page-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%);
        pointer-events: none;
        z-index: -1;
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
    <?php include '../../inc/amigoNavbar.php'; ?>

    <div class="container">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div class="buttons-container">
                    <h2>Árboles Disponibles</h2>
                </div>
                <a href="dashboard.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <?php if (isset($_SESSION['success_message'])): ?> <div class="alert alert-success alert-dismissible fade show"
            role="alert">
            <?php 
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
                ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <?php if (empty($trees)): ?>
        <div class="alert alert-info">
            No hay árboles disponibles en este momento.
        </div>
        <?php else: ?>
        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php foreach ($trees as $tree): ?>
            <div class="col">
                <div class="card h-100">
                    <?php if ($tree['foto_url']): ?>
                    <img src="../../uploads/arboles/<?php echo htmlspecialchars($tree['foto_url']); ?>"
                        class="card-img-top" alt="Foto del árbol" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                    <div class="bg-light text-center py-5">
                        <i class="bi bi-tree-fill text-success" style="font-size: 4rem;"></i>
                    </div>
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($tree['nombre_comercial']); ?></h5>
                        <p class="card-text">
                            <small class="text-muted">
                                <?php echo htmlspecialchars($tree['nombre_cientifico']); ?>
                            </small>
                        </p>
                        <p class="card-text">
                            <i class="bi bi-geo-alt-fill text-primary"></i>
                            <?php echo htmlspecialchars($tree['ubicacion_geografica']); ?>
                        </p>
                        <p class="card-text">
                            <strong>Precio: </strong>
                            ₡<?php echo number_format($tree['precio'], 2); ?>
                        </p>
                    </div>
                    <div class="card-footer border-top-0">
                        <div class="d-grid gap-2">
                            <a href="comprarArbol.php?id=<?php echo $tree['id']; ?>" class="btn btn-primary">
                                <i class="bi bi-cart-plus"></i> Adquirir Árbol
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>