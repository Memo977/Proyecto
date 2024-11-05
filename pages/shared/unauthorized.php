<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso No Autorizado</title>
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
        animation: fadeIn 0.5s ease-out;
    }

    .card-title {
        color: #ff4444;
        /* Rojo para el mensaje de no autorizado */
        font-weight: 600;
        font-size: 2rem;
    }

    .card-text {
        color: #e0e0e0;
        font-size: 1.1rem;
        margin-bottom: 1.5rem;
    }

    .btn-primary {
        background-color: rgba(92, 107, 192, 0.9);
        border-color: transparent;
        transition: all 0.3s ease;
        font-weight: 500;
        padding: 0.625rem 2rem;
    }

    .btn-primary:hover {
        background-color: rgba(63, 81, 181, 0.95);
        border-color: transparent;
        transform: translateY(-1px);
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
                    <div class="card-body p-5 text-center">
                        <h1 class="card-title mb-4">Acceso No Autorizado</h1>
                        <p class="card-text">Lo sentimos, no tiene permisos para acceder a esta sección.</p>
                        <a href="javascript:history.back()" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>