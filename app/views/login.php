<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inicio de Sesion</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>

    

<!-- Contenedor que centra todo vertical y horizontalmente en la pantalla -->
<div class="container d-flex justify-content-center align-items-center vh-100">
    
    <!-- Caja que limita el ancho en computadoras -->
    <div class="col-12 col-md-6 col-lg-4">
        
        <form action="index.php?action=login" method="POST" class="p-4 border rounded bg-white shadow-sm">
            <h3 class="text-center mb-4">Inicio De Sesion</h3>

            <!-- 1 USUARIO -->
            <div class="mb-3">
                <label for="usuario" class="form-label font-weight-bold">Usuario</label>
                <input class="form-control" type="text" id="usuario" name="username" placeholder="Nombre de usuario" required>
            </div>


            <!-- 2 CONTRASENA -->
            <div class="mb-4">
                <label for="password" class="form-label">Contraseña</label>
                <!-- Al ser type="password", el navegador oculta el texto con puntos automaticamente -->
                <input class="form-control" type="password" id="password" name="password" placeholder="Ingresa tu contraseña" required>
            </div>


            <!-- BOTON DE ACCION -->
            <button type="submit" class="btn btn-primary w-100">Iniciar sesion</button>
            
<p class="text-center mt-3">
    ¿No tienes cuenta? <a href="index.php?action=registro">Registrate aquí</a>
</p>


        </form>
        
    </div>
</div>






   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>
