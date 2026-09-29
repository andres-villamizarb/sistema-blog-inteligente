<?php
/** @var array $post */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?action=login");
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($post['titulo'] ?? 'Publicación'); ?> - Mi Blog</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .post-detail-img {
            max-height: 450px;
            object-fit: cover;
            width: 100%;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php?action=home">
                <i class="bi bi-journal-code me-2"></i>Mi Blog
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=crear_post">Crear Post</a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-danger btn-sm px-3" href="index.php?action=logout">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                <!-- Botón Volver -->
                <div class="mb-3">
                    <a href="index.php?action=home" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Volver a publicaciones
                    </a>
                </div>

                <article class="card shadow-sm border-0 p-4 mb-4">
                    <!-- Título -->
                    <h1 class="fw-bold text-dark mb-3"><?php echo htmlspecialchars($post['titulo']); ?></h1>

                    <!-- Metadatos -->
                    <div class="d-flex align-items-center gap-2 mb-4 text-muted small flex-wrap border-bottom pb-3">
                        <?php if (!empty($post['categoria'])): ?>
                            <span class="badge bg-primary">
                                <i class="bi bi-tag-fill me-1"></i><?php echo htmlspecialchars($post['categoria']); ?>
                            </span>
                        <?php endif; ?>
                        <span class="badge bg-secondary">
                            <i class="bi bi-person-fill"></i> <?php echo htmlspecialchars($post['autor']); ?>
                        </span>
                        <span>
                            <i class="bi bi-clock me-1"></i><?php echo date('d/m/Y H:i', strtotime($post['fecha'])); ?>
                        </span>
                    </div>

                    <!-- Imagen -->
                    <?php if (!empty($post['imagen'])): ?>
                        <div class="mb-4">
                            <img src="<?php echo htmlspecialchars($post['imagen']); ?>" class="post-detail-img shadow-sm" alt="<?php echo htmlspecialchars($post['titulo']); ?>">
                        </div>
                    <?php endif; ?>

                    <!-- Contenido Completo -->
                    <div class="post-content text-secondary fs-6 lh-lg mb-4">
                        <?php echo nl2br(htmlspecialchars($post['contenido'])); ?>
                    </div>

                    <!-- Opciones de Autor -->
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === $post['autor']): ?>
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="index.php?action=editar_post&id=<?php echo $post['id']; ?>" class="btn btn-warning btn-sm fw-bold">
                                <i class="bi bi-pencil me-1"></i> Editar
                            </a>
                            <a href="index.php?action=eliminar_post&id=<?php echo $post['id']; ?>" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('¿Seguro que deseas eliminar esta publicación?');">
                                <i class="bi bi-trash me-1"></i> Eliminar
                            </a>
                        </div>
                    <?php endif; ?>
                </article>

            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-top py-3 mt-auto">
        <div class="container text-center text-muted small">
            &copy; <?php echo date('Y'); ?> Mi Blog - Todos los derechos reservados.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>