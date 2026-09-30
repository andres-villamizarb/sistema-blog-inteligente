<?php
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
    <!-- Cargar TinyMCE -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.8.3/tinymce.min.js"></script>

<!-- Inicializar el editor -->
<script>
  tinymce.init({
    selector: '#contenido',
    plugins: 'lists link code preview',
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist | code',
    menubar: false,
    height: 400,
    // Eliminamos language: 'es' para evitar el bloqueo de Edge
    
    // Esta función asegura que el formulario de PHP reciba el texto al publicar
    setup: function (editor) {
        editor.on('change', function () {
            editor.save(); 
        });
    }
  });
</script>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Publicación - Mi Blog AI</title>
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
                    <div class="card-header bg-success text-white py-3">
                        <h4 class="mb-0 fs-5 fw-bold"><i class="bi bi-plus-circle me-2"></i>Crear Nueva Publicación</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="index.php?action=crear_post" method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="titulo" class="form-label fw-bold mb-0">Título de la publicación</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" id="btn-titulo" onclick="solicitarIA('titulo')">
                                        ✨ Sugerir Título IA
                                    </button>
                                </div>
                                <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Escribe un título llamativo">
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label fw-bold">Categoría / Sección</label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="" disabled selected>Selecciona una categoría</option>
                                    <option value="Programación">Programación</option>
                                    <option value="Tecnología">Tecnología</option>
                                    <option value="Sistemas">Sistemas</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <label for="contenido" class="form-label fw-bold mb-0">Contenido</label>
                                    <button type="button" class="btn btn-sm btn-outline-primary shadow-sm" id="btn-corregir" onclick="solicitarIA('corregir')">
                                        ✨ Corregir Ortografía IA
                                    </button>
                                </div>
                                <textarea class="form-control" id="contenido" name="contenido" rows="8" required placeholder="Escribe tu contenido aquí..."></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="imagen" class="form-label fw-bold">Imagen de portada (Opcional)</label>
                                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                                <a href="index.php?action=home" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success px-4 fw-semibold">Publicar Entrada</button>
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
    <script src="scriptIA.js"></script>
</body>
</html>