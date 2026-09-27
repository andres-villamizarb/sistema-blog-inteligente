<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php?action=home">Mi Blog</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?action=home">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?action=crear_post">Crear Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="index.php?action=logout">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Últimas Publicaciones</h2>
            <a href="index.php?action=crear_post" class="btn btn-success">Escribir algo nuevo</a>
        </div>
        
        <div class="row">
            <?php if (!empty($posts)): ?>
                <?php foreach ($posts as $post): ?>
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $post['titulo']; ?></h5>
                                <h6 class="card-subtitle mb-3 text-muted">
                                    Por <strong><?php echo $post['autor']; ?></strong> el <?php echo date('d/m/Y H:i', strtotime($post['fecha'])); ?>
                                </h6>
                                <p class="card-text"><?php echo nl2br($post['contenido']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info">Aún no hay publicaciones. ¡Sé el primero en escribir algo!</div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>