<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?action=login");
    exit();
}

$post = $post ?? ['id' => '', 'titulo' => '', 'categoria' => 'General', 'contenido' => '', 'imagen' => ''];

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicación - Mi Blog AI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- CSS Externo -->
    <link rel="stylesheet" href="/sistema_blogg/public/css/styles.css?v=<?php echo time(); ?>">
</head>
<body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Navegación Superior Unificada -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php?action=home">
                <i class="bi bi-cpu-fill text-primary fs-4"></i>
                <span>Mi Blog <span class="badge badge-ai rounded-pill ms-1 fs-6">AI Powered</span></span>
            </a>
            <div class="ms-auto">
                <a class="btn btn-outline-light btn-sm" href="index.php?action=home">
                    <i class="bi bi-arrow-left me-1"></i> Volver al Inicio
                </a>
            </div>
        </div>
    </nav>

    <main class="container flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <div class="card shadow-sm border-0 mb-4 rounded-3">
                    <div class="card-header bg-warning text-dark py-3">
                        <h4 class="mb-0 fs-5 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Publicación</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="index.php?action=editar_post&id=<?php echo $post['id']; ?>" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="titulo" class="form-label fw-bold mb-0">Título</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" id="btn-titulo" onclick="solicitarIA('titulo')">
                                        ✨ Sugerir Título IA
                                    </button>
                                </div>
                                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($post['titulo']); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoría / Sección</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="Programación" <?php echo ($post['categoria'] ?? '') === 'Programación' ? 'selected' : ''; ?>>Programación</option>
                                    <option value="Tecnología" <?php echo ($post['categoria'] ?? '') === 'Tecnología' ? 'selected' : ''; ?>>Tecnología</option>
                                    <option value="Sistemas" <?php echo ($post['categoria'] ?? '') === 'Sistemas' ? 'selected' : ''; ?>>Sistemas</option>
                                    <option value="General" <?php echo ($post['categoria'] ?? '') === 'General' ? 'selected' : ''; ?>>General</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="contenido" class="form-label fw-bold mb-0">Contenido</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" id="btn-corregir" onclick="solicitarIA('corregir')">
                                        ✨ Corregir Ortografía IA
                                    </button>
                                </div>
                                <textarea class="form-control" id="contenido" name="contenido" rows="8" required><?php echo htmlspecialchars($post['contenido']); ?></textarea>
                            </div>

                            <?php if (!empty($post['imagen'])): ?>
                                <div class="mb-3">
                                    <label class="form-label fw-bold d-block">Imagen actual</label>
                                    <img src="<?php echo htmlspecialchars($post['imagen']); ?>" class="img-thumbnail rounded" style="max-height: 180px;">
                                </div>
                            <?php endif; ?>

                            <div class="mb-4">
                                <label for="imagen" class="form-label fw-bold">Cambiar imagen (Opcional)</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <a href="index.php?action=home" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-warning px-4 fw-semibold">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <footer class="bg-dark text-white-50 py-3 mt-auto border-top border-secondary">
        <div class="container text-center small">
            &copy; <?php echo date('Y'); ?> Mi Blog AI - Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>