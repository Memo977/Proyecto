<?php
session_start();
require_once '../../utils/functions.php';
checkAuth();

if ($_SESSION['rol_id'] != 2) {
    header('Location: unauthorized.php');
    exit();
}

$tree_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$tree = getTreeWithDetails($tree_id);

if (!$tree || $tree['usuario_id'] != $_SESSION['user_id']) {
    $_SESSION['error_message'] = "No tienes permiso para ver este árbol.";
    header('Location: mis_arboles.php');
    exit();
}

$updates = getTreeUpdateHistory($tree_id);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Árbol - Sistema de Gestión de Árboles</title>
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
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        transition: transform 0.3s ease;
        animation: fadeIn 0.5s ease-out;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-header {
        background-color: rgba(61, 61, 61, 0.7);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-title {
        color: #ffffff;
        margin-bottom: 0;
    }

    .card-body {
        padding: 1.5rem;
    }

    .img-fluid {
        border-radius: 10px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }

    .text-muted {
        color: #b3b3b3 !important;
    }

    .badge {
        padding: 0.5em 0.8em;
        font-weight: 500;
        color: #ffffff;
    }

    .badge.bg-success {
        background-color: rgba(40, 167, 69, 0.9) !important;
    }

    .btn-secondary {
        background-color: rgba(108, 117, 125, 0.9);
        border-color: transparent;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-secondary:hover {
        background-color: rgba(83, 91, 99, 0.95);
        border-color: transparent;
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
        background-color: rgba(108, 117, 125, 0.9);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-right: 1rem;
        font-weight: 500;
    }

    .btn-back:hover {
        background-color: rgba(90, 98, 104, 0.95);
        color: white;
        transform: translateY(-2px);
    }

    .timeline {
        border-left: 2px solid rgba(255, 255, 255, 0.2);
        padding-left: 1.5rem;
    }

    .timeline .border-start {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }

    .img-thumbnail {
        background-color: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        transition: transform 0.3s ease;
    }

    .img-thumbnail:hover {
        transform: scale(1.1);
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
                    <h2>Detalles</h2>
                </div>
                <a href="dashboard.php" class="btn btn-primary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Información del Árbol</h5>
                    </div>
                    <div class="card-body">
                        <?php if ($tree['foto_url']): ?>
                        <div class="text-center">
                            <img src="../../uploads/arboles/<?php echo htmlspecialchars($tree['foto_url']); ?>"
                                class="img-fluid rounded shadow-sm mb-3" alt="Foto del árbol"
                                style="max-height: 400px; width: 100%; object-fit: cover; object-position: center;">
                        </div>
                        <?php endif; ?>

                        <h4><?php echo htmlspecialchars($tree['nombre_comercial']); ?></h4>
                        <p class="text-muted"><?php echo htmlspecialchars($tree['nombre_cientifico']); ?></p>

                        <dl class="row">
                            <dt class="col-sm-4">Ubicación:</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($tree['ubicacion_geografica']); ?></dd>

                            <dt class="col-sm-4">Estado:</dt>
                            <dd class="col-sm-8">
                                <span class="badge bg-success">
                                    <?php echo htmlspecialchars($tree['estado']); ?>
                                </span>
                            </dd>

                            <?php if (isset($tree['fecha_venta'])): ?>
                            <dt class="col-sm-4">Fecha de Adquisición:</dt>
                            <dd class="col-sm-8">
                                <?php echo date('d/m/Y', strtotime($tree['fecha_venta'])); ?>
                            </dd>
                            <?php endif; ?>
                        </dl>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Historial de Actualizaciones</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($updates)): ?>
                        <p class="text-muted">No hay actualizaciones registradas.</p>
                        <?php else: ?>
                        <div class="timeline">
                            <?php foreach ($updates as $update): ?>
                            <div class="border-start border-2 ps-3 pb-3">
                                <div class="text-muted small">
                                    <?php echo date('d/m/Y H:i', strtotime($update['fecha_actualizacion'])); ?>
                                </div>
                                <div class="mt-1">
                                    <strong>Tamaño:</strong>
                                    <?php echo htmlspecialchars($update['tamanio_actual']); ?> metros
                                </div>
                                <?php if ($update['descripcion']): ?>
                                <div class="mt-1">
                                    <strong>Descripción:</strong>
                                    <?php echo htmlspecialchars($update['descripcion']); ?>
                                </div>
                                <?php endif; ?>
                                <?php if ($update['foto']): ?>
                                <div class="mt-2 text-center">
                                    <img src="../../uploads/actualizaciones/<?php echo htmlspecialchars($update['foto']); ?>"
                                        class="img-fluid rounded shadow-sm" alt="Foto de actualización"
                                        style="max-height: 300px; width: 100%; object-fit: cover; object-position: center;">
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>