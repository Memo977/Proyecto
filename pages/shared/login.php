<?php
session_start();
require_once('../../utils/functions.php');

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['rol_id'] == 1) {
        header('Location: ../admin/dashboard.php');
    } else {
        header('Location: ../amigo/dashboard.php');
    }
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Un Millón de Árboles - Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

    .main-title {
        text-align: center;
        margin-bottom: 2rem;
        color: #ffffff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        animation: fadeInDown 1s ease-out;
    }

    .main-title h1 {
        font-size: 5rem;
        font-weight: 700;
        font-style: italic;
        letter-spacing: 1px;
    }

    .main-title p {
        font-size: 1.2rem;
        font-weight: 300;
        font-style: italic;
        max-width: 600px;
        margin: 0 auto;
    }

    .container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 2rem 0;
    }

    .card {
        background: rgba(45, 45, 45, 0.85);
        backdrop-filter: blur(10px);
        border: none;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.4);
    }

    .card-title {
        color: #ffffff;
        font-weight: 600;
    }

    .form-label {
        color: #e0e0e0;
        font-weight: 500;
    }

    .form-control {
        background-color: rgba(61, 61, 61, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #ffffff;
        backdrop-filter: blur(5px);
    }

    .form-control:focus {
        background-color: rgba(61, 61, 61, 0.9);
        border-color: rgba(92, 107, 192, 0.5);
        color: #ffffff;
        box-shadow: 0 0 0 0.25rem rgba(92, 107, 192, 0.25);
    }

    .btn-primary {
        background-color: rgba(92, 107, 192, 0.9);
        border-color: transparent;
        transition: all 0.3s ease;
        font-weight: 500;
        padding: 0.625rem;
    }

    .btn-primary:hover {
        background-color: rgba(63, 81, 181, 0.95);
        border-color: transparent;
        transform: translateY(-1px);
    }

    .alert-danger {
        background-color: rgba(74, 28, 28, 0.9);
        border-color: rgba(105, 39, 39, 0.5);
        color: #ff9a9a;
    }

    .alert-success {
        background-color: rgba(28, 74, 28, 0.9);
        border-color: rgba(39, 105, 39, 0.5);
        color: #9aff9a;
    }

    a {
        color: #a5aeff;
        text-decoration: none;
        transition: color 0.3s ease;
        font-weight: 500;
    }

    a:hover {
        color: #ffffff;
    }

    input:-webkit-autofill,
    input:-webkit-autofill:hover,
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: #ffffff;
        -webkit-box-shadow: 0 0 0px 1000px rgba(61, 61, 61, 0.9) inset;
        transition: background-color 5000s ease-in-out 0s;
    }

    .card {
        animation: fadeIn 0.5s ease-out;
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

    /* Agregamos un overlay con gradiente para el fondo */
    .page-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at center, rgba(0, 0, 0, 0.4) 0%, rgba(0, 0, 0, 0.6) 100%);
        pointer-events: none;
    }
    </style>
</head>

<body>
    <div class="page-overlay"></div>
    <div class="container">
        <div class="main-title">
            <h1>Un Millón de Árboles</h1>
            <p>Juntos por un futuro más verde y sostenible</p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Iniciar Sesión</h2>
                        <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger">
                            Credenciales inválidas. Por favor, intente nuevamente.
                        </div>
                        <?php endif; ?>
                        <?php if (isset($_GET['registered'])): ?>
                        <div class="alert alert-success">
                            Registro exitoso. Por favor, inicie sesión.
                        </div>
                        <?php endif; ?>
                        <form action="../../actions/login.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                        <div class="text-center mt-3">
                            <p>¿No tienes una cuenta? <a href="signup.php">Regístrate aquí</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>