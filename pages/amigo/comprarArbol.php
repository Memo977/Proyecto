<?php
session_start();
require_once '../../utils/functions.php';
checkAuth();

if ($_SESSION['rol_id'] != 2) {
    header('Location: unauthorized.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: arboles_disponibles.php');
    exit();
}

$tree = getTree($_GET['id']);

if (!$tree || $tree['estado'] !== 'Disponible') {
    $_SESSION['error_message'] = "El árbol no está disponible para su compra.";
    header('Location: arboles_disponibles.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Compra - Sistema de Gestión de Árboles</title>
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

    .card-header {
        background-color: #1a1a1a;
        color: #ffffff;
    }

    .card-title {
        color: #ffffff;
        font-weight: 600;
    }

    .card-text {
        color: #e0e0e0;
    }

    .card {
        background: rgba(45, 45, 45, 0.85);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-img-top {
        height: 300px;
        object-fit: cover;
        border-top-left-radius: 15px;
        border-top-right-radius: 15px;
    }

    .card-title {
        color: #ffffff;
        font-weight: 600;
    }

    .card-text {
        color: #e0e0e0;
    }

    .list-unstyled li {
        margin-bottom: 0.5rem;
    }

    .alert {
        border-radius: 10px;
        border: none;
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

    .btn-secondary {
        background-color: rgba(108, 117, 125, 0.9);
        border-color: rgba(108, 117, 125, 0.9);
        color: #fff;
        transition: all 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: rgba(90, 98, 104, 0.95);
        border-color: rgba(90, 98, 104, 0.95);
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

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Confirmar Compra de Árbol</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <?php if ($tree['foto_url']): ?>
                                <img src="../../uploads/arboles/<?php echo htmlspecialchars($tree['foto_url']); ?>"
                                    class="img-fluid rounded" alt="Foto del árbol">
                                <?php else: ?>
                                <div class="bg-light text-center py-5 rounded">
                                    <i class="bi bi-tree-fill text-success" style="font-size: 6rem;"></i>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <h5 class="mb-3">Detalles del Árbol</h5>
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <strong>Especie:</strong><br>
                                        <?php echo htmlspecialchars($tree['nombre_comercial']); ?>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Nombre Científico:</strong><br>
                                        <em><?php echo htmlspecialchars($tree['nombre_cientifico']); ?></em>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Ubicación:</strong><br>
                                        <?php echo htmlspecialchars($tree['ubicacion_geografica']); ?>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Precio:</strong><br>
                                        €<?php echo number_format($tree['precio'], 2); ?>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle-fill"></i>
                            Al confirmar la compra, este árbol quedará registrado como suyo y podrá realizar seguimiento
                            de su crecimiento y estado.
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="arbolesDisponibles.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancelar
                            </a>
                            <form action="../../actions/comprarArbol.php" method="POST" class="d-inline">
                                <input type="hidden" name="tree_id" value="<?php echo $tree['id']; ?>">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-cart-check"></i> Confirmar Compra
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>