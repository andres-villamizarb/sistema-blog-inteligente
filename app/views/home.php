<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?action=login");
    exit();
}

$paginaActual = $paginaActual ?? 1;

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Blog - Plataforma Inteligente</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Hoja de Estilos Externa -->
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navegación Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php?action=home">
                <i class="bi bi-cpu-fill text-primary fs-4"></i>
                <span>Mi Blog <span class="badge badge-ai rounded-pill ms-1 fs-6">AI Powered</span></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2">
                    <li class="nav-item">
                        <a class="nav-link active fw-medium" href="index.php?action=home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="index.php?action=crear_post">
                            <i class="bi bi-pencil-square me-1"></i>Crear Post
                        </a>
                    </li>
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-outline-danger btn-sm px-3" href="index.php?action=logout">
                            <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Banner Principal (Hero Section) -->
    <header class="hero-banner text-white py-5 mb-4">
        <div class="container">
            <div class="row align-items-center py-3">
                <div class="col-lg-8">
                    <span class="badge badge-ai mb-2 px-3 py-2 text-uppercase">
                        <i class="bi bi-magic me-1"></i> Sistema Inteligente de Contenidos
                    </span>
                    <h1 class="display-5 fw-bold mb-3">Plataforma de Blogging Asistida por IA</h1>
                    <p class="lead text-light opacity-75 mb-4">
                        Explora publicaciones optimizadas con inteligencia artificial, recomendaciones personalizadas según tu navegación y resúmenes automáticos.
                    </p>
                    <div class="d-flex flex-wrap gap-2">
                        <a href="index.php?action=crear_post" class="btn btn-ai-magic btn-lg px-4 shadow-sm">
                            <i class="bi bi-robot me-2"></i>Escribir con Asistente IA
                        </a>
                        <a href="#explorar" class="btn btn-outline-light btn-lg px-4">
                            Explorar Artículos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="container flex-grow-1 mb-5" id="explorar">
        
        <!-- Barra Superior: Título, Buscador y Filtros -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-md-5">
                <h3 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                    <i class="bi bi-journal-text text-primary"></i> Publicaciones Recientes
                </h3>
            </div>
            <div class="col-md-7">
                <form action="index.php" method="GET" class="input-group shadow-sm">
                    <input type="hidden" name="action" value="home">
                    <?php if (!empty($_GET['categoria'])): ?>
                        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($_GET['categoria']); ?>">
                    <?php endif; ?>
                    <input type="text" name="buscar" class="form-control border-end-0" placeholder="Buscar por título, contenido o tema con IA..." value="<?php echo htmlspecialchars($_GET['buscar'] ?? ''); ?>">
                    <button class="btn btn-primary px-4" type="submit">
                        <i class="bi bi-search me-1"></i> Buscar
                    </button>
                </form>
            </div>
        </div>

        <!-- Categorías Estilizadas -->
        <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
            <a href="index.php?action=home" class="btn btn-sm px-3 rounded-pill <?php echo empty($_GET['categoria']) ? 'btn-dark' : 'btn-outline-dark'; ?>">
                Todas
            </a>
            <a href="index.php?action=home&categoria=Programación" class="btn btn-sm px-3 rounded-pill <?php echo (($_GET['categoria'] ?? '') === 'Programación') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Programación
            </a>
            <a href="index.php?action=home&categoria=Tecnología" class="btn btn-sm px-3 rounded-pill <?php echo (($_GET['categoria'] ?? '') === 'Tecnología') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Tecnología
            </a>
            <a href="index.php?action=home&categoria=Sistemas" class="btn btn-sm px-3 rounded-pill <?php echo (($_GET['categoria'] ?? '') === 'Sistemas') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                Sistemas
            </a>
            <a href="index.php?action=home&categoria=General" class="btn btn-sm px-3 rounded-pill <?php echo (($_GET['categoria'] ?? '') === 'General') ? 'btn-primary' : 'btn-outline-primary'; ?>">
                General
            </a>
        </div>

        <!-- Grid Principal: Contenido + Sidebar -->
        <div class="row g-4">
            
            <!-- Columna Izquierda: Grid de Tarjetas (8/12) -->
            <div class="col-lg-8">
                <div class="row g-4">
                    <?php if (!empty($posts)): ?>
                        <?php foreach ($posts as $post): ?>
                            <div class="col-md-6">
                                <div class="card blog-card h-100 border-0 shadow-sm d-flex flex-column">
                                    
                                    <!-- Contenedor de Imagen -->
                                    <div class="post-img-container d-flex align-items-center justify-content-center text-muted">
                                        <?php if (!empty($post['imagen'])): ?>
                                            <img src="<?php echo htmlspecialchars($post['imagen']); ?>" alt="Portada del post">
                                        <?php else: ?>
                                            <div class="text-center text-black-50">
                                                <i class="bi bi-file-post fs-1 d-block mb-1 text-secondary"></i>
                                                <span class="small">Sin vista previa</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="card-body d-flex flex-column flex-grow-1 p-4">
                                        
                                        <!-- Badges: Categoría e IA -->
                                        <div class="d-flex align-items-center gap-2 mb-2 flex-wrap">
                                            <a href="index.php?action=home&categoria=<?php echo urlencode($post['categoria'] ?? 'General'); ?>" class="badge bg-primary-subtle text-primary fw-bold text-decoration-none px-2 py-1">
                                                <i class="bi bi-tag-fill me-1"></i><?php echo htmlspecialchars($post['categoria'] ?? 'General'); ?>
                                            </a>
                                            <span class="badge bg-light text-dark border small">
                                                <i class="bi bi-person-circle me-1"></i><?php echo htmlspecialchars($post['autor']); ?>
                                            </span>
                                        </div>

                                        <!-- Título -->
                                        <h5 class="card-title fw-bold text-dark mb-2">
                                            <?php echo htmlspecialchars($post['titulo']); ?>
                                        </h5>

                                        <!-- Fecha -->
                                        <p class="text-muted small mb-3">
                                            <i class="bi bi-calendar3 me-1"></i><?php echo date('d/m/Y H:i', strtotime($post['fecha'])); ?>
                                        </p>
                                        
                                        <!-- Contenido / Resumen con IA -->
                                        <p class="card-text text-secondary small mb-4 flex-grow-1">
                                            <?php 
                                                $textoLimpio = strip_tags($post['contenido']);
                                                $resumen = mb_strlen($textoLimpio) > 110 ? mb_substr($textoLimpio, 0, 110) . '...' : $textoLimpio;
                                                echo nl2br(htmlspecialchars($resumen)); 
                                            ?>
                                        </p>

                                        <!-- Acciones -->
                                        <div class="pt-3 border-top mt-auto">
                                            <a href="index.php?action=ver_post&id=<?php echo $post['id']; ?>" class="btn btn-primary btn-sm w-100 fw-semibold mb-2">
                                                Leer artículo completo <i class="bi bi-arrow-right ms-1"></i>
                                            </a>

                                            <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario'] === $post['autor']): ?>
                                                <div class="d-flex justify-content-end gap-2 pt-1">
                                                    <a href="index.php?action=editar_post&id=<?php echo $post['id']; ?>" class="btn btn-outline-warning btn-sm py-0 px-2">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="index.php?action=eliminar_post&id=<?php echo $post['id']; ?>" class="btn btn-outline-danger btn-sm py-0 px-2" onclick="return confirm('¿Deseas eliminar este post?');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12">
                            <div class="alert alert-light border text-center py-5 shadow-sm rounded-3">
                                <i class="bi bi-search fs-1 text-muted d-block mb-2"></i>
                                <h5 class="fw-bold text-dark">No se encontraron artículos</h5>
                                <p class="text-muted small">Intenta ajustar tu búsqueda o seleccionar otra categoría.</p>
                                <a href="index.php?action=home" class="btn btn-outline-primary btn-sm mt-2">
                                    Ver todas las publicaciones
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Paginación -->
                <?php if (isset($totalPaginas) && $totalPaginas > 1): ?>
                    <?php 
                        $params = [];
                        if (!empty($_GET['buscar'])) $params[] = 'buscar=' . urlencode($_GET['buscar']);
                        if (!empty($_GET['categoria'])) $params[] = 'categoria=' . urlencode($_GET['categoria']);
                        $queryString = !empty($params) ? '&' . implode('&', $params) : '';
                    ?>
                    <nav class="mt-4">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?php echo ($paginaActual <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?action=home&pagina=<?php echo ($paginaActual - 1) . $queryString; ?>">Anterior</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?php echo ($i === $paginaActual) ? 'active' : ''; ?>">
                                    <a class="page-link" href="index.php?action=home&pagina=<?php echo $i . $queryString; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php echo ($paginaActual >= $totalPaginas) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="index.php?action=home&pagina=<?php echo ($paginaActual + 1) . $queryString; ?>">Siguiente</a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>

            <!-- Columna Derecha: Sidebar con Funcionalidades de IA (4/12) -->
            <div class="col-lg-4">
                
                <!-- Widget: Asistente Inteligente -->
                <div class="card border-0 shadow-sm mb-4 rounded-3">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="badge badge-ai p-2 rounded-circle">
                                <i class="bi bi-robot fs-5"></i>
                            </span>
                            <h5 class="fw-bold mb-0">Funciones de IA</h5>
                        </div>
                        <p class="small text-muted mb-3">
                            Esta plataforma integra Inteligencia Artificial para mejorar la creación y lectura de contenido:
                        </p>
                        <ul class="list-unstyled small lh-lg text-secondary mb-0">
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i><strong>Sugerencia de Títulos y Temas</strong> al redactar.</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i><strong>Resumen Automático</strong> de publicaciones extensas.</li>
                            <li><i class="bi bi-check-circle-fill text-primary me-2"></i><strong>Corrección Gramatical</strong> en tiempo real.</li>
                            
                        </ul>
                    </div>
                </div>

                <!-- Widget: Recomendado para ti -->
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                            <i class="bi bi-stars text-warning"></i> Recomendados por IA
                        </h6>
                        <div class="d-flex flex-column gap-3">
                            <div class="p-2 rounded bg-light border-start border-3 border-primary">
                                <a href="#" class="fw-bold text-dark text-decoration-none small d-block mb-1">Optimizando el Frontend con MVC</a>
                                <span class="text-muted extra-small" style="font-size: 0.75rem;">Basado en tu interés en Programación</span>
                            </div>
                            <div class="p-2 rounded bg-light border-start border-3 border-info">
                                <a href="#" class="fw-bold text-dark text-decoration-none small d-block mb-1">Patrones de Arquitectura Web</a>
                                <span class="text-muted extra-small" style="font-size: 0.75rem;">Popular en la categoría Sistemas</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- Pie de Página -->
    <footer class="bg-dark text-white-50 py-4 mt-auto border-top border-secondary">
        <div class="container text-center small">
            <p class="mb-1">&copy; <?php echo date('Y'); ?> Mi Blog AI - Plataforma de Blogging Inteligente.</p>
            <p class="mb-0 opacity-50">Desarrollado con PHP, Bootstrap 5 e Integración con APIs de Inteligencia Artificial.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>