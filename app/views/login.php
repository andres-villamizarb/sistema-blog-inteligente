<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de Sesión - Mi Blog AI</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- CSS Externo (Ruta raíz del proyecto) -->
    <link rel="stylesheet" href="/sistema_blogg/public/css/styles.css?v=<?php echo time(); ?>">
  </head>
  <body class="d-flex flex-column min-vh-100 bg-light">

    <!-- Navbar Superior -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="index.php">
                <i class="bi bi-cpu-fill text-primary fs-4"></i>
                <span>Mi Blog <span class="badge badge-ai rounded-pill ms-1 fs-6">AI Powered</span></span>
            </a>
            <div class="ms-auto d-flex gap-2">
                <a href="index.php?action=login" class="btn btn-outline-light btn-sm px-3 active">
                    <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar Sesión
                </a>
                <a href="index.php?action=registro" class="btn btn-ai-primary btn-sm px-3">
                    <i class="bi bi-person-plus-fill me-1"></i> Registrarse
                </a>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="container d-flex flex-grow-1 align-items-center justify-content-center py-5">
        <div class="col-12 col-md-8 col-lg-5">
            
            <form action="index.php?action=login" method="POST" class="auth-card p-4 p-md-5 shadow-lg">
                
                <div class="text-center mb-4">
                    <div class="d-inline-block p-3 rounded-circle bg-primary-subtle text-primary mb-3">
                        <i class="bi bi-box-arrow-in-right fs-2"></i>
                    </div>
                    <h3 class="fw-bold text-dark mb-1">Inicio De Sesión</h3>
                    <p class="text-muted small">Ingresa a tu cuenta para continuar</p>
                </div>

                <!-- ===== ZONA DE ALERTAS ===== -->
                <?php if (isset($error) && !empty($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i> <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($_GET['success'])): ?>
                    <div class="alert alert-success alert-dismissible fade show small" role="alert">
                        <i class="bi bi-check-circle-fill me-1"></i> Registro exitoso. Ya puedes iniciar sesión.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <!-- =========================== -->

                <div class="mb-3">
                    <label for="usuario" class="form-label fw-semibold text-secondary">Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-person"></i></span>
                        <input 
                            class="form-control" 
                            type="text" 
                            id="usuario" 
                            name="username" 
                            placeholder="Nombre de usuario" 
                            required
                            minlength="3"
                            maxlength="20"
                            pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+"
                            title="Solo se permiten letras y espacios (entre 3 y 20 caracteres)"
                            onkeypress="return soloLetras(event)"
                        >
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label fw-semibold text-secondary">Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-lock"></i></span>
                        <input 
                            class="form-control" 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Ingresa tu contraseña" 
                            required
                            minlength="6"
                            maxlength="16"
                            pattern="[a-zA-Z0-9]+"
                            title="Solo se permiten letras y números sin caracteres especiales (entre 6 y 16 caracteres)"
                            onkeypress="return sinEspeciales(event)"
                        >
                    </div>
                </div>

                <button type="submit" class="btn btn-ai-primary w-100 py-2 shadow-sm mb-3">
                    Iniciar sesión <i class="bi bi-arrow-right ms-1"></i>
                </button>
                
                <div class="text-center pt-3 border-top">
                    <p class="small text-muted mb-0">
                        ¿No tienes cuenta? <a href="index.php?action=registro" class="fw-bold text-primary text-decoration-none">Regístrate aquí</a>
                    </p>
                </div>

            </form>
            
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white-50 py-3 mt-auto border-top border-secondary">
        <div class="container text-center small">
            &copy; <?php echo date('Y'); ?> Mi Blog AI - Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function soloLetras(e) {
            let key = e.keyCode || e.which;
            let tecla = String.fromCharCode(key);
            let regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
            if (key === 8 || key === 46 || key === 37 || key === 39) return true;
            return regex.test(tecla);
        }

        function sinEspeciales(e) {
            let key = e.keyCode || e.which;
            let tecla = String.fromCharCode(key);
            let regex = /^[a-zA-Z0-9]+$/;
            if (key === 8 || key === 46 || key === 37 || key === 39) return true;
            return regex.test(tecla);
        }
    </script>
  </body>
</html>