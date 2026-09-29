<?php

class UserModel {
    private $filePath;

    public function __construct() {
        $this->filePath = __DIR__ . '/../../data/users.json';
    }

    private function getAllUsers() {
        if (!file_exists($this->filePath)) {
            return [];
        }
        $jsonData = file_get_contents($this->filePath);
        return json_decode($jsonData, true) ?: [];
    }

    // Registrar un nuevo usuario de forma segura
    public function register($username, $password) {
        $users = $this->getAllUsers();

        // Verificar si el usuario ya existe
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return false; // El usuario ya está registrado
            }
        }

        // Crear hash de la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $newUser = [
            'id' => time(),
            'username' => $username,
            'password' => $hashedPassword
        ];

        $users[] = $newUser;

        file_put_contents($this->filePath, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }

    // Verificar credenciales para el login
    public function login($username, $password) {
        $users = $this->getAllUsers();

        foreach ($users as $user) {
            if ($user['username'] === $username) {
                // Verificar la contraseña cifrada
                if (password_verify($password, $user['password'])) {
                    return true; // Credenciales correctas
                }
            }
        }

        return false; // Credenciales inválidas
    }
}