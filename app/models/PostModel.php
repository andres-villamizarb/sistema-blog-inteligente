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
        return json_decode($jsonData, true) ?: [];
    }

    // Guardar una nueva publicación
    public function save($newPost) {
        $posts = $this->getAll();
        
        // Asignar un ID único basado en el tiempo o en el conteo
        $newPost['id'] = time();
        
        $posts[] = $newPost;
        
        // Guardar con formato legible
        file_put_contents($this->filePath, json_encode($posts, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }
}