<?php

class PostModel {
    private $filePath;

    public function __construct() {
        $this->filePath = __DIR__ . '/../../data/posts.json';
    }

    // Leer todas las publicaciones
    public function getAll() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $jsonData = file_get_contents($this->filePath);
        $posts = json_decode($jsonData, true) ?: [];
        // Ordenar del más reciente al más antiguo
        usort($posts, fn($a, $b) => strtotime($b['fecha']) - strtotime($a['fecha']));
        return $posts;
    }

    // Obtener un post por su ID
    public function getById($id) {
        $posts = $this->getAll();
        foreach ($posts as $post) {
            if ((string)$post['id'] === (string)$id) {
                return $post;
            }
        }
        return null;
    }

    // Guardar una nueva publicación
    public function save($newPost) {
        $posts = $this->getAll();
        $posts[] = $newPost;
        file_put_contents($this->filePath, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }

    // Actualizar un post existente
    public function update($id, $titulo, $contenido, $imagen = null) {
        $posts = $this->getAll();
        foreach ($posts as &$post) {
            if ((string)$post['id'] === (string)$id) {
                $post['titulo'] = htmlspecialchars($titulo);
                $post['contenido'] = htmlspecialchars($contenido);
                if ($imagen !== null) {
                    if (!empty($post['imagen']) && file_exists($post['imagen'])) {
                        unlink($post['imagen']);
                    }
                    $post['imagen'] = $imagen;
                }
                break;
            }
        }
        return file_put_contents($this->filePath, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // Eliminar una publicación y su archivo de imagen
    public function delete($id) {
        $posts = $this->getAll();
        $filtered = [];
        
        foreach ($posts as $post) {
            if ((string)$post['id'] === (string)$id) {
                if (!empty($post['imagen']) && file_exists($post['imagen'])) {
                    unlink($post['imagen']);
                }
            } else {
                $filtered[] = $post;
            }
        }

        return file_put_contents($this->filePath, json_encode($filtered, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    // ==========================================================
    // BÚSQUEDA Y PAGINACIÓN PARA JSON (CON SOPORTE DE CATEGORÍA)
    // ==========================================================

    public function searchPosts($buscar = '', $categoria = '') {
        $posts = $this->getAll();
        
        if (empty($buscar) && empty($categoria)) {
            return $posts;
        }

        $term = mb_strtolower($buscar);
        $catTerm = mb_strtolower($categoria);
        
        return array_values(array_filter($posts, function($post) use ($term, $catTerm) {
            $cumpleBuscar = true;
            $cumpleCategoria = true;

            if (!empty($term)) {
                $titulo = mb_strtolower($post['titulo'] ?? '');
                $contenido = mb_strtolower($post['contenido'] ?? '');
                $cumpleBuscar = (strpos($titulo, $term) !== false || strpos($contenido, $term) !== false);
            }

            if (!empty($catTerm)) {
                $postCategoria = mb_strtolower($post['categoria'] ?? 'general');
                $cumpleCategoria = ($postCategoria === $catTerm);
            }

            return $cumpleBuscar && $cumpleCategoria;
        }));
    }

    // Obtener las publicaciones paginadas del arreglo filtrado
    public function getPaginated($posts, $pagina = 1, $porPagina = 6) {
        $inicio = ($pagina - 1) * $porPagina;
        return array_slice($posts, $inicio, $porPagina);
    }
}
?>