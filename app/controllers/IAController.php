<?php
class IAController {
    // Pega tu Trial Key de Cohere aquí
    private string $apiKey = 'axD90LAHbQv1AlqukLzx7F2ufaGwZvRkyfixuiLc';

    public function procesarPeticion() {
        header('Content-Type: application/json');
        
        // Capturamos lo que envía JavaScript
        $input = json_decode(file_get_contents('php://input'), true);
        $texto = $input['texto'] ?? '';
        $accion = $input['accion'] ?? '';

        if (empty($texto)) {
            echo json_encode(['error' => 'Texto vacío']);
            return;
        }

     // Preparamos las instrucciones
        $prompt = "";
        if ($accion === 'corregir') {
            $prompt = "Corrige los errores ortográficos y gramaticales del siguiente texto. Responde ÚNICAMENTE con el texto corregido, sin explicaciones adicionales:\n\n" . $texto;
        } else if ($accion === 'titulo') {
            $prompt = "Genera una opcion de título atractivo para un blog basado en este texto. Responde ÚNICAMENTE con un título:\n\n" . $texto;
        } else if ($accion === 'resumir') {
            $prompt = "Escribe un resumen corto, directo y atractivo del siguiente texto. Responde ÚNICAMENTE con el resumen:\n\n" . $texto;
        } else {
            $prompt = $texto;
        }

        // Configuración de la API de Cohere v2
        $url = "https://api.cohere.com/v2/chat";
        
        // Estructura oficial para Cohere v2
        $data = [
            "model" => "command-a-plus-05-2026", 
            "messages" => [
                [
                    "role" => "user",
                    "content" => $prompt
                ]
            ],
            "temperature" => 0.7
        ];

        // Iniciamos la conexión con cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $this->apiKey,
            "Content-Type: application/json",
            "Accept: application/json"
        ]);

        $response = curl_exec($ch);
        
        if(curl_errno($ch)){
            echo json_encode(['error' => curl_error($ch)]);
            curl_close($ch);
            return;
        }
        curl_close($ch);

        $responseData = json_decode($response, true);
        
        // Extraemos la respuesta de Cohere v2 buscando el bloque de texto
        if (isset($responseData['message']['content'])) {
            $resultado = '';
            // Recorremos la respuesta para ignorar el "thinking" y agarrar solo el texto
            foreach ($responseData['message']['content'] as $bloque) {
                if (isset($bloque['type']) && $bloque['type'] === 'text') {
                    $resultado = $bloque['text'];
                    break;
                }
            }
            
            if ($resultado !== '') {
                echo json_encode(['resultado' => trim($resultado)]);
            } else {
                echo json_encode(['error' => 'No se encontró texto en la respuesta', 'detalles' => $response]);
            }
        } else {
            echo json_encode(['error' => 'Error en la API de Cohere', 'detalles' => $response]);
        }
    }
}
?>