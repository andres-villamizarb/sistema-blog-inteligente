<?php
// Requerimos el modelo de publicaciones creado en la Fase 1
require_once 'app/models/PostModel.php';

class PostController {

    private PostModel $postModel;

    public function __construct() {
        // Inicializamos el modelo para manejar la lectura y escritura en posts.json
        $this->postModel = new PostModel();
    }

    // 1. Muestra la lista completa de publicaciones en la página principal
    public function index() {
        // Obtenemos todos los posts desde el archivo data/posts.json
        $posts = $this->postModel->getAll();

        // Cargamos la vista principal enviándole el listado de publicaciones
        require_once 'app/views/home.php';
    }

    // 2. Gestiona el formulario y la creación de una nueva publicación
    public function create() {
        // Verificación de seguridad: solo usuarios con sesión iniciada pueden publicar
        session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        // Si el usuario envió el formulario por método POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Capturamos y sanitizamos los datos de las cajas de texto
            $titulo = trim($_POST['titulo'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');

            // Validamos que los campos no estén vacíos
            if (!empty($titulo) && !empty($contenido)) {

                // Armamos la estructura de la nueva publicación
                $newPost = [
                    'id' => time(), // ID único basado en timestamp
                    'titulo' => htmlspecialchars($titulo),
                    'contenido' => htmlspecialchars($contenido),
                    'autor' => $_SESSION['usuario'],
                    'fecha' => date('Y-m-d H:i:s')
                ];

                // Guardamos el post usando el modelo
                $this->postModel->save($newPost);

                // Redirigimos al Home para ver la nueva publicación publicada
                header("Location: index.php?action=home");
                exit();

            } else {
                // Si faltó algún campo, enviamos un mensaje de error a la vista
                $error = "Todos los campos son obligatorios.";
                require_once 'app/views/crear_post.php';
            }

        } else {
            // Si entra por GET (solo a ver la pantalla), cargamos el formulario de creación
            require_once 'app/views/crear_post.php';
        }
    }
}
?>