<?php
session_start();
require_once '../../utils/functions.php';
checkAuth();
checkAdminRole();

$arbol_id = isset($_GET['id']) ? $_GET['id'] : 0;
$arbol = getTree($arbol_id);

if (!$arbol) {
    $_SESSION['error_message'] = "Árbol no encontrado.";
    header('Location: amigos.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Árbol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    /* Estilos compartidos para crearArbol.php y editarArbol.php */
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
        animation: fadeIn 0.5s ease-out;
    }

    .card-header {
        background-color: rgba(61, 61, 61, 0.7);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 15px 15px 0 0 !important;
        padding: 1.5rem;
    }

    .card-title {
        color: #ffffff;
        margin: 0;
        font-weight: 600;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .card-body {
        padding: 2rem;
    }

    .form-label {
        color: #e0e0e0;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        background-color: rgba(61, 61, 61, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        backdrop-filter: blur(5px);
        padding: 0.75rem;
        border-radius: 8px;
    }

    .form-control:focus,
    .form-select:focus {
        background-color: rgba(61, 61, 61, 0.9);
        border-color: rgba(92, 107, 192, 0.5);
        color: #ffffff;
        box-shadow: 0 0 0 0.25rem rgba(92, 107, 192, 0.25);
    }

    .form-select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23ffffff' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
    }

    .form-select option {
        background-color: rgba(45, 45, 45, 0.95);
        color: #ffffff;
    }

    .input-group-text {
        background-color: rgba(61, 61, 61, 0.9);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .btn {
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background-color: rgba(92, 107, 192, 0.9);
        border-color: transparent;
    }

    .btn-primary:hover {
        background-color: rgba(63, 81, 181, 0.95);
        border-color: transparent;
        transform: translateY(-2px);
    }

    .btn-secondary {
        background-color: rgba(108, 117, 125, 0.9);
        border-color: transparent;
    }

    .btn-secondary:hover {
        background-color: rgba(90, 98, 104, 0.95);
        transform: translateY(-2px);
    }

    .gap-2 {
        gap: 1rem !important;
    }

    /* Estilos para la imagen del árbol */
    .img-thumbnail {
        background-color: rgba(61, 61, 61, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 0.5rem;
    }

    /* Autofill styles */
    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: #ffffff;
        -webkit-box-shadow: 0 0 0px 1000px rgba(61, 61, 61, 0.9) inset;
        transition: background-color 5000s ease-in-out 0s;
    }

    /* Page overlay */
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
    </style>
</head>

<body>
    <div class="page-overlay"></div>
    <?php include '../../inc/adminNavbar.php'; ?>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Registrar Actualización de Árbol</h3>
                    </div>
                    <div class="card-body">
                        <form action="../../actions/amigos.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="UpdateFriendTree">
                            <input type="hidden" name="arbol_id" value="<?php echo $arbol_id; ?>">

                            <div class="mb-3">
                                <label for="tamanio" class="form-label">Tamaño Actual (metros)</label>
                                <input type="number" class="form-control" id="tamanio" name="tamanio" step="0.01"
                                    min="0" required>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Disponible">Disponible</option>
                                    <option value="Vendido">Vendido</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción de la actualización</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                    placeholder="Describe los cambios o novedades observadas en el árbol..."></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="photo" class="form-label">Foto de la actualización (opcional)</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="javascript:history.back()" class="btn btn-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-primary">Guardar Actualización</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>