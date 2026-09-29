<?php
// Previene que el navegador guarde la página en caché
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'app/controllers/IAController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/PostController.php';

$iaController = new IAController();
$authController = new AuthController();
$postController = new PostController();

// Acción por defecto al entrar al sitio
$action = isset($_GET['action']) ? $_GET['action'] : 'landing';

switch ($action) {
    case 'landing':
        require_once 'app/views/landing.php';
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

    case 'ver_post':
        // Carga la lectura individual del post según la ID recibida por GET
        $postController->show();
        break;

    case 'crear_post':
        $postController->create();
        break;

    case 'editar_post':
        $postController->edit();
        break;

    case 'eliminar_post':
        $postController->delete();
        break;
        
    case 'api_ia':
        $iaController->procesarPeticion();
        break;

    default:
        require_once 'app/views/landing.php';
        break;
}