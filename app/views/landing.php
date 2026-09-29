<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si ya inició sesión, redirigir a home
if (isset($_SESSION['usuario'])) {
    header("Location: index.php?action=home");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido - Mi Blog AI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            color: #212529;
        }

        .hero-section {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            border-bottom: 4px solid #2563eb;
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: center;
        }

        .badge-ai {
            background: linear-gradient(90deg, #6366f1, #8b5cf6);
            color: #ffffff;
            font-weight: 600;
        }

        .btn-ai-primary {
            background: linear-gradient(90deg, #2563eb, #3b82f6);
            color: #ffffff;
            border: none;
            font-weight: 600;
            transition: all 0.25s ease;
        }

        .btn-ai-primary:hover {
            background: linear-gradient(90deg, #1d4ed8, #2563eb);
            color: #ffffff;
            transform: translateY(-2px);
        }

        .feature-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }

        .feature-icon-wrapper {
            width: 60px;
            height: 60px;
            background: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin: 0 auto 1.5rem auto;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navegación Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-cpu-fill text-primary fs-4"></i>
                <span>Mi Blog <span class="badge badge-ai rounded-pill ms-1 fs-6">AI Powered</span></span>
            </a>
            <div class="ms-auto d-flex gap-2">
                <a href="index.php?action=login" class="btn btn-outline-light btn-sm px-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                </a>
                <a href="index.php?action=registro" class="btn btn-ai-primary btn-sm px-3">
                    <i class="bi bi-person-plus-fill me-1"></i> Registrarse
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section / Contenido Principal -->
    <header class="hero-section text-white py-5 flex-grow-1">
        <div class="container">
            <div class="row align-items-center g-5">
                
                <!-- Columna Izquierda: Texto Principal -->
                <div class="col-lg-6">
                    <span class="badge badge-ai mb-3 px-3 py-2 text-uppercase">
                        <i class="bi bi-stars me-1"></i> Inteligencia Artificial Integrada
                    </span>
                    <h1 class="display-4 fw-bold mb-3">Crea y comparte publicaciones potenciadas con IA</h1>
                    <p class="lead text-light opacity-75 mb-4">
                        Una plataforma moderna para redactar artículos con sugerencias de títulos, corrección gramatical en tiempo real, resúmenes automáticos y recomendaciones personalizadas.
                    </p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="index.php?action=registro" class="btn btn-ai-primary btn-lg px-4 shadow-sm">
                            Empezar ahora <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                        <a href="index.php?action=login" class="btn btn-outline-light btn-lg px-4">
                            Ya tengo cuenta
                        </a>
                    </div>
                </div>

                <!-- Columna Derecha: Tarjeta Destacada de IA -->
                <div class="col-lg-6">
                    <div class="feature-card p-4 p-md-5 text-center shadow-lg text-dark">
                        <div class="feature-icon-wrapper">
                            <i class="bi bi-robot"></i>
                        </div>
                        <h3 class="fw-bold mb-3">Publicaciones e Ideas al Instante</h3>
                        <p class="text-secondary mb-4">
                            Escribe más rápido gracias a la sugerencia automática de temas y resúmenes inteligentes diseñados para optimizar tu experiencia de lectura y escritura.
                        </p>
                        <div class="d-flex justify-content-center gap-2 flex-wrap">
                            <span class="badge bg-primary-subtle text-primary border px-3 py-2">Sugerencias IA</span>
                            <span class="badge bg-primary-subtle text-primary border px-3 py-2">Resúmenes</span>
                            <span class="badge bg-primary-subtle text-primary border px-3 py-2">Ortografía</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </header>

    <!-- Pie de Página -->
    <footer class="bg-dark text-white-50 py-3 mt-auto border-top border-secondary">
        <div class="container text-center small">
            &copy; <?php echo date('Y'); ?> Mi Blog AI - Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>