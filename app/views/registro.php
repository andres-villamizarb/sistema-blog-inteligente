<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="col-12 col-md-6 col-lg-4">
        
        <form action="index.php?action=registro" method="POST" class="p-4 border rounded bg-white shadow-sm">
            <h3 class="text-center mb-4">Crear Cuenta</h3>

            <!-- ===== ZONA DE ALERTAS ===== -->
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- =========================== -->

            <div class="mb-3">
                <label for="usuario" class="form-label fw-bold">Nuevo Usuario</label>
                <input class="form-control" type="text" id="usuario" name="username" placeholder="Elige un nombre de usuario" required>
            </div>

            <div class="mb-4">
                <label for="password" class="form-label fw-bold">Contraseña</label>
                <input class="form-control" type="password" id="password" name="password" placeholder="Crea una contraseña segura" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrarme</button>
            
            <p class="text-center mt-3 mb-0">
                ¿Ya tienes cuenta? <a href="index.php?action=login" class="text-decoration-none">Inicia sesión aquí</a>
            </p>

        </form>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

