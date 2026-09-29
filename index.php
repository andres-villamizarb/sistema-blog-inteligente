<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Previene que el navegador guarde la página en caché
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

require_once 'app/controllers/IAController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/PostController.php';

$iaController = new IAController();
$authController = new AuthController();
$postController = new PostController();

// Ahora la acción por defecto es 'landing'
$action = isset($_GET['action']) ? $_GET['action'] : 'landing';

switch ($action) {
    case 'landing':
        // Si ya hay sesión activa, va directo al feed principal
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?action=home");
            exit();
        }
        require_once 'app/views/landing.php';
        break;

    case 'ver_post':
        $postController->show();
        break;

    case 'editar_post':
        $postController->edit();
        break;

    case 'eliminar_post':
        $postController->delete();
        break;

    case 'login':
        $authController->login(); 
        break;
    
    case 'registro':
        $authController->registro(); 
        break;
    
    case 'logout':
        $authController->logout(); 
        break;
        
    case 'home':
        $postController->index();
        break;

    case 'crear_post':
        $postController->create();
        break;
        
    case 'api_ia':
        $iaController->procesarPeticion();
        break;

    default:
        // Si ingresa una ruta desconocida y no tiene sesión, muestra la landing
        if (isset($_SESSION['usuario'])) {
            header("Location: index.php?action=home");
        } else {
            require_once 'app/views/landing.php';
        }
        exit();
}
?>