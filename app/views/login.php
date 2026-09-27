<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de Sesion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body class="bg-light">

<!-- Contenedor que centra todo vertical y horizontalmente en la pantalla -->
<div class="container d-flex justify-content-center align-items-center vh-100">
    
    <!-- Caja que limita el ancho en computadoras -->
    <div class="col-12 col-md-6 col-lg-4">
        
        <form action="index.php?action=login" method="POST" class="p-4 border rounded bg-white shadow-sm">
            <h3 class="text-center mb-4">Inicio De Sesión</h3>

            <!-- ===== ZONA DE ALERTAS ===== -->
            <?php if (isset($error) && !empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Registro exitoso. Ya puedes iniciar sesión.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            <!-- =========================== -->

            <!-- 1 USUARIO -->
            <div class="mb-3">
                <label for="usuario" class="form-label fw-bold">Usuario</label>
                <input class="form-control" type="text" id="usuario" name="username" placeholder="Nombre de usuario" required>
            </div>

            <!-- 2 CONTRASENA -->
            <div class="mb-4">
                <label for="password" class="form-label fw-bold">Contraseña</label>
                <!-- Al ser type="password", el navegador oculta el texto con puntos automáticamente -->
                <input class="form-control" type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>

            <!-- BOTON DE ACCION -->
            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
            
            <p class="text-center mt-3 mb-0">
                ¿No tienes cuenta? <a href="index.php?action=registro" class="text-decoration-none">Regístrate aquí</a>
            </p>

        </form>
        
    </div>
</div>

<!-- Script de Bootstrap necesario para cerrar las alertas -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
