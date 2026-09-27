<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Nueva Publicación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php?action=home">Mi Blog</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="index.php?action=home">Volver al Inicio</a>
                </li>
            </ul>
        </div>
    </nav>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Mostrar mensaje de error si el controlador lo envía -->
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0">Escribir nuevo post</h4>
                    </div>
                    <div class="card-body">
                        <form action="index.php?action=crear_post" method="POST">
                            <div class="mb-3">
                                <label for="titulo" class="form-label">Título de la publicación</label>
                                <input type="text" class="form-control" id="titulo" name="titulo" required placeholder="Escribe un título llamativo">
                            </div>
                            
                            <div class="mb-4">
                                <label for="contenido" class="form-label">Contenido</label>
                                <textarea class="form-control" id="contenido" name="contenido" rows="6" required placeholder="¿Qué quieres compartir hoy?"></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-between">
                                <a href="index.php?action=home" class="btn btn-outline-secondary">Cancelar</a>
                                <button type="submit" class="btn btn-success">Publicar Entrada</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>