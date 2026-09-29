<?php

require_once 'app/models/UserModel.php';

class AuthController {
    
    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    private function prevenirCache(): void {
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    // 1. Lógica para iniciar sesión
    public function login() {
        $this->prevenirCache();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si ya hay sesión activa, redirigir directamente al home
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?action=home");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // VALIDACIONES DE BACKEND (LOGIN)
            if (empty($username) || empty($password)) {
                $error = "Todos los campos son obligatorios.";
                require_once 'app/views/login.php';
                return;
            }

            if (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]{3,20}$/", $username)) {
                $error = "El usuario solo debe contener letras y tener entre 3 y 20 caracteres.";
                require_once 'app/views/login.php';
                return;
            }

         // Ejemplo de validación dentro de login() o registro()
if (!preg_match("/^[a-zA-Z0-9]{6,16}$/", $password)) {
    $error = "La contraseña solo debe contener letras y números (de 6 a 16 caracteres), sin caracteres especiales.";
    require_once 'app/views/login.php'; // o registro.php según corresponda
    return;
}

            $loginValido = $this->userModel->login($username, $password);

            if ($loginValido) {
                // Guardar usuario en sesión usando la clave estandarizada 'usuario'
                $_SESSION['usuario'] = $username;
                header("Location: index.php?action=home");
                exit();
            } else {
                $error = "Credenciales incorrectas. Inténtalo de nuevo.";
                require_once 'app/views/login.php';
            }
            
        } else {
            require_once 'app/views/login.php';
        }
    }

    // 2. Lógica para registrar un usuario nuevo
    public function registro() {
        $this->prevenirCache();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?action=home");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            // VALIDACIONES DE BACKEND (REGISTRO)
            if (empty($username)) {
                $error = "El nombre de usuario es obligatorio.";
            } elseif (strlen($username) < 3 || strlen($username) > 20) {
                $error = "El nombre de usuario debe tener entre 3 y 20 caracteres.";
            } elseif (!preg_match("/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/", $username)) {
                $error = "El nombre de usuario solo puede contener letras y espacios.";
            } elseif (empty($password)) {
                $error = "La contraseña es obligatoria.";
            } elseif (strlen($password) < 6 || strlen($password) > 16) {
                $error = "La contraseña debe tener entre 6 y 16 caracteres.";
            } elseif (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
                $error = "La contraseña solo puede contener letras y números, sin caracteres especiales.";
            }

            if (isset($error)) {
                require_once 'app/views/registro.php';
                return;
            }

            $registroExitoso = $this->userModel->register($username, $password);

            if ($registroExitoso) {
                header("Location: index.php?action=login&success=1");
                exit();
            } else {
                $error = "El nombre de usuario ya está en uso. Elige otro.";
                require_once 'app/views/registro.php';
            }
            
        } else {
            require_once 'app/views/registro.php';
        }
    }

    // 3. Lógica para cerrar sesión limpiando cookies y sesión
    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
        $this->prevenirCache();

        header("Location: index.php?action=landing");
        exit();
    }
}
?>