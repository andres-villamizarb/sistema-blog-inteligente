<?php
require_once 'app/controllers/IAController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/PostController.php';

$iaController = new IAController();
$authController = new AuthController();
$postController = new PostController();

$action = isset($_GET['action']) ? $_GET['action'] : 'login';

switch ($action) {
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
        // Ahora ejecutamos la acción index() de PostController en lugar del echo temporal
        $postController->index();
        break;

    case 'crear_post':
        // Acción para procesar y guardar la nueva publicación
        $postController->create();
        break;
        
    case 'api_ia':
    $iaController->procesarPeticion();
    break;

    default:
        $authController->login();
        break;
}
?>