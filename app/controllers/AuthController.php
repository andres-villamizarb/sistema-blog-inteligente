<?php

// Requerimos el modelo que creó el Integrante 1 para poder usarlo
require_once 'app/models/UserModel.php';

class AuthController {
    
    private $userModel;

    public function __construct() {
        // Inicializamos el modelo para conectarnos a la base de datos (o al JSON)
        $this->userModel = new UserModel();
    }

    // 1. Lógica para iniciar sesión
    public function login() {
        // PASO 1: Verificamos si el usuario envió el formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // PASO 2: Capturamos y limpiamos los datos del HTML
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // PASO 3: Le pasamos los datos a la herramienta login() del Integrante 1
            // Recuerda que su función devuelve 'true' si la contraseña es correcta, o 'false' si se equivocó.
            $loginValido = $this->userModel->login($username, $password);

            // PASO 4: Tomamos decisiones según lo que respondió el Modelo
            if ($loginValido) {
                // ¡Éxito! Iniciamos la sesión del usuario en el servidor
                session_start();
                $_SESSION['usuario'] = $username; // Guardamos su nombre en la sesión para proteger las rutas luego
                
                // Lo enviamos a la pantalla principal del blog (el home)
                header("Location: index.php?action=home");
                exit();
            } else {
                // Fallo: Usuario o contraseña incorrectos
                $error = "Credenciales incorrectas. Inténtalo de nuevo.";
                require_once 'app/views/login.php'; // Recargamos la vista mostrándole el error
            }
            
        } else {
            // PASO 5: Si solo entró a la página sin enviar nada, le mostramos el formulario de login normal
            require_once 'app/views/login.php';
        }
    }

    // 2. Lógica para registrar un usuario nuevo
    public function registro() {
        // PASO 1: Preguntamos, ¿el usuario llegó aquí porque le dio clic al botón de enviar formulario?
        // (En la web, cuando envías datos ocultos, se usa el método 'POST')
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // PASO 2: Capturamos los datos que el usuario escribió en las cajas de texto del HTML
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // PASO 3: Le pasamos esos datos a la herramienta que creó tu compañero (El Modelo)
            $registroExitoso = $this->userModel->register($username, $password);

            // PASO 4: El Controlador (TÚ) toma decisiones basándose en la respuesta del Modelo
            if ($registroExitoso) {
                // Si el Modelo dijo 'true' (se guardó con éxito), redirigimos al usuario a la página de Login
                header("Location: index.php?action=login");
                exit(); // Siempre ponemos exit después de un header para detener el código
            } else {
                // Si el Modelo dijo 'false' (el usuario ya existía), guardamos un mensaje de error
                $error = "El nombre de usuario ya está en uso. Elige otro.";
                // Y volvemos a mostrarle la pantalla de registro para que lo intente de nuevo
                require_once 'app/views/registro.php';
            }
            
        } else {
            // PASO 5: Si el usuario simplemente escribió la dirección web (no envió nada por POST),
            // simplemente le mostramos la pantalla de registro vacía.
            require_once 'app/views/registro.php';
        }
    }
    // 3. Lógica para cerrar sesión
    public function logout() {
        session_start();
        session_destroy(); // Destruimos todas las variables de sesión
        header("Location: index.php?action=login"); // Redirigimos al usuario al login
        exit();
    }
}
?>