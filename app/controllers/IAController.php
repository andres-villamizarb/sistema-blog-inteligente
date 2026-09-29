<?php

class IAController {
    
    // API KEY
    private string $apiKey = 'AQUI_VA_TU_API_KEY';

    public function procesarPeticion() {
        // Le decimos al navegador que vamos a devolver un JSON
        header('Content-Type: application/json');

        // Capturamos lo que envíe el JavaScript desde el frontend
        $input = json_decode(file_get_contents('php://input'), true);
        $texto = $input['texto'] ?? '';
        $accion = $input['accion'] ?? 'corregir'; // Puede ser 'corregir' o 'titulo'

        if (empty($texto)) {
            echo json_encode(['error' => 'No se recibió texto.']);
            exit();
        }

        // Definimos las instrucciones para la IA según lo que pida el usuario
        if ($accion === 'titulo') {
            $prompt = "Eres un experto en SEO y redacción de blogs. Lee el siguiente texto y sugiere 3 títulos atractivos y cortos. Devuelve solo los títulos, separados por guiones: \n\n" . $texto;
        } else {
            $prompt = "Eres un editor profesional. Corrige los errores ortográficos y gramaticales del siguiente texto, mejorando la redacción pero manteniendo el tono original. Devuelve únicamente el texto corregido, sin explicaciones extra: \n\n" . $texto;
        }

        // Preparamos la URL de la API de Gemini (usamos el modelo 1.5 Flash que es rapidísimo)
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-3.8-flash:generateContent?key=" . trim($this->apiKey);

        // Estructura de datos que exige Google
        $data = [
            "contents" => [
                ["parts" => [["text" => $prompt]]]
            ]
        ];

        // Configuramos cURL para hacer la petición por POST
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Ejecutamos y cerramos
        $response = curl_exec($ch);
        curl_close($ch);

        // Devolvemos la respuesta cruda de Google al frontend para que JS la procese
        echo $response;
        exit();
    }
}
?>