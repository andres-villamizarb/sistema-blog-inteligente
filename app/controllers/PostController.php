<?php
require_once 'app/models/PostModel.php';

class PostController {

    private PostModel $postModel;

    public function __construct() {
        $this->postModel = new PostModel();
    }

    private function prevenirCache() {
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    private function subirImagen() {
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
            $dir = 'uploads/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }

            $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $extensionesPermitidas = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

            if (in_array($ext, $extensionesPermitidas)) {
                $nombreArchivo = uniqid('img_') . '.' . $ext;
                $rutaDestino = $dir . $nombreArchivo;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
                    return $rutaDestino;
                }
            }
        }
        return null;
    }

    public function index() {
        $this->prevenirCache();

        if (session_status() === PHP_SESSION_NONE) session_start();
        
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        // 1. Obtener parámetros de búsqueda y categoría
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $categoria = isset($_GET['categoria']) ? trim($_GET['categoria']) : '';
        
        $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        if ($paginaActual < 1) $paginaActual = 1;

        $porPagina = 6;

        // 2. Obtener publicaciones filtradas por buscador
        $postsFiltrados = $this->postModel->searchPosts($buscar);

        // 3. Filtrar por categoría (si se seleccionó una categoría específica)
        if (!empty($categoria)) {
            $postsFiltrados = array_filter($postsFiltrados, function($post) use ($categoria) {
                return isset($post['categoria']) && strcasecmp($post['categoria'], $categoria) === 0;
            });
            // Reindexar el array para mantener índices secuenciales
            $postsFiltrados = array_values($postsFiltrados);
        }

        // 4. Calcular paginación sobre los resultados filtrados
        $totalPosts = count($postsFiltrados);
        $totalPaginas = (int)ceil($totalPosts / $porPagina);

        $posts = $this->postModel->getPaginated($postsFiltrados, $paginaActual, $porPagina);

        require_once 'app/views/home.php';
    }

    public function show() {
        $this->prevenirCache();

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id = $_GET['id'] ?? '';
        $post = $this->postModel->getById($id);

        if (!$post) {
            header("Location: index.php?action=home");
            exit();
        }

        require_once 'app/views/ver_post.php';
    }

    public function create() {
        $this->prevenirCache();

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');
            $categoria = trim($_POST['categoria'] ?? 'General');
            $imagen = $this->subirImagen();

            if (!empty($titulo) && !empty($contenido)) {
                $newPost = [
                    'id' => time(),
                    'titulo' => $titulo,
                    'contenido' => $contenido,
                    'categoria' => $categoria,
                    'autor' => $_SESSION['usuario'],
                    'imagen' => $imagen,
                    'fecha' => date('Y-m-d H:i:s')
                ];

                $this->postModel->save($newPost);
                header("Location: index.php?action=home");
                exit();
            } else {
                $error = "Todos los campos son obligatorios.";
                require_once 'app/views/crear_post.php';
            }
        } else {
            require_once 'app/views/crear_post.php';
        }
    }

    public function edit() {
        $this->prevenirCache();

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id = $_GET['id'] ?? '';
        $post = $this->postModel->getById($id);

        if (!$post || $post['autor'] !== $_SESSION['usuario']) {
            header("Location: index.php?action=home");
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = trim($_POST['titulo'] ?? '');
            $contenido = trim($_POST['contenido'] ?? '');
            $nuevaImagen = $this->subirImagen();

            if (!empty($titulo) && !empty($contenido)) {
                $this->postModel->update($id, $titulo, $contenido, $nuevaImagen);
                header("Location: index.php?action=home");
                exit();
            } else {
                $error = "Todos los campos son obligatorios.";
                require_once 'app/views/editar_post.php';
            }
        } else {
            require_once 'app/views/editar_post.php';
        }
    }

    public function delete() {
        $this->prevenirCache();

        if (session_status() === PHP_SESSION_NONE) session_start();
        if (!isset($_SESSION['usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        $id = $_GET['id'] ?? '';
        $post = $this->postModel->getById($id);

        if ($post && $post['autor'] === $_SESSION['usuario']) {
            $this->postModel->delete($id);
        }

        header("Location: index.php?action=home");
        exit();
    }
    
}
?>