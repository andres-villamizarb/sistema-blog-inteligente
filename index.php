<?php
require_once 'app/controllers/AuthController.php';

$authController = new AuthController();
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
        // Iniciamos la sesión para poder leer la memoria del servidor
        session_start();
        
        // Verificamos si el usuario tiene su "brazalete VIP" activo
        if (isset($_SESSION['usuario'])) {
            echo "<div style='text-align: center; margin-top: 50px; font-family: sans-serif;'>";
            echo "<h1>¡Acceso Concedido!</h1>";
            echo "<h2>Bienvenido al panel privado, <b>" . $_SESSION['usuario'] . "</b></h2>";
            echo "<br><a href='index.php?action=logout' style='padding: 10px 20px; background: red; color: white; text-decoration: none; border-radius: 5px;'>Cerrar Sesión</a>";
            echo "</div>";
        } else {
            // Si intenta saltarse el login y entrar directo por la URL, lo devolvemos
            header("Location: index.php?action=login");
        }
        break;
    
    default:
        $authController->login();
        break;
}
?>