<?php
session_start();
require_once '../../utils/functions.php';
checkAuth();

$user_id = $_SESSION['user_id'];
$profile = getUserProfile($user_id);

$stats = getFriendDashboardStats($user_id);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    /* Estilos para la página de perfil */
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.7)), url('https://www.arenalobservatorylodge.com/wp-content/uploads/2023/01/Volcan-Arenal-4.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #ffffff;
        /* Cambiar el color del texto a blanco */
        font-family: 'Poppins', sans-serif;
    }

    .card {
        background: rgba(45, 45, 45, 0.85);
        backdrop-filter: blur(10px);
        border: none !important;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        color: #ffffff;
        /* Cambiar el color del texto de la card a blanco */
    }

    .card-header {
        background-color: rgba(61, 61, 61, 0.9);
        color: #ffffff;
        /* Cambiar el color del texto del header a blanco */
        font-weight: 600;
    }

    .form-control {
        background-color: rgba(61, 61, 61, 0.9);
        border-color: rgba(165, 174, 255, 0.3);
        color: #ffffff;
        /* Cambiar el color del texto del formulario a blanco */
    }

    .btn-primary {
        background-color: #a5aeff;
        border-color: #a5aeff;
        color: #2d2d2d;
        /* Cambiar el color del texto del botón a oscuro */
    }

    .btn-primary:hover {
        background-color: #8790e6;
        border-color: #8790e6;
    }

    .text-primary {
        color: #a5aeff !important;
    }

    /* Navbar customization */
    .navbar {
        background: rgba(45, 45, 45, 0.9) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
        color: #ffffff;
        /* Cambiar el color del texto de la barra de navegación a blanco */
    }

    .navbar-brand,
    .nav-link {
        color: #ffffff !important;
        /* Cambiar el color del texto de la barra de navegación a blanco */
    }

    .nav-link:hover {
        color: #a5aeff !important;
    }
    </style>
</head>

<body>

    <?php include '../../inc/amigoNavbar.php'; ?>

    <div class="container py-5">
        <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <?php 
                echo $_SESSION['success_message'];
                unset($_SESSION['success_message']);
                ?>
        </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger">
            <?php 
                echo $_SESSION['error_message'];
                unset($_SESSION['error_message']);
                ?>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Información Personal</h4>
                    </div>
                    <div class="card-body">
                        <form action="../../actions/perfil.php" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre"
                                    value="<?php echo htmlspecialchars($profile['nombre']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Apellidos:</label>
                                <input type="text" class="form-control" name="apellidos"
                                    value="<?php echo htmlspecialchars($profile['apellidos']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <input type="email" class="form-control" name="email"
                                    value="<?php echo htmlspecialchars($profile['email']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" name="telefono"
                                    value="<?php echo htmlspecialchars($profile['telefono']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Dirección:</label>
                                <textarea class="form-control"
                                    name="direccion"><?php echo htmlspecialchars($profile['direccion']); ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">País:</label>
                                <input type="text" class="form-control" name="pais"
                                    value="<?php echo htmlspecialchars($profile['pais']); ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nueva Contraseña: (Dejar en blanco para mantener la
                                    actual)</label>
                                <input type="password" class="form-control" name="new_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Actualizar Perfil</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Información de la Cuenta</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Rol:</strong> <?php echo htmlspecialchars($profile['rol_nombre']); ?></p>
                        <p><strong>Fecha de Registro:</strong>
                            <?php echo date('d/m/Y', strtotime($profile['created_at'])); ?></p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Estadísticas</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Mis Árboles:</strong> <?php echo $stats['arboles_propios']; ?></p>
                        <p><strong>Última Actualización:</strong>
                            <?php 
                                echo $stats['ultima_actualizacion'] 
                                    ? date('d/m/Y H:i', strtotime($stats['ultima_actualizacion'])) 
                                    : 'Sin actualizaciones';
                                ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>