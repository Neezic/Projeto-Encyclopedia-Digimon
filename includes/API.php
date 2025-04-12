<?php 

function getDigimons(){
    $url = "https://digi-api.com/api/v1/digimon";
    $response = file_get_contents($url);
    return json_decode($response, true)['content'];
}
function getDigimonsPorId($id){
    $url = "https://digi-api.com/api/v1/digimon/$id";
    $response = file_get_contents($url);
    if ($response == FALSE){
        return ['erro' => 'Falha ao acessar API'];
    }
    $data = json_decode($response, true);
    if (json_last_error() !== JSON_ERROR_NONE){
        return ['erro' => 'Dados inválidos da API'];
    }
    return $data;
}

function handleApiResponse($response) {
    if (!$response) {
        return ['error' => 'Falha ao acessar a API'];
    }
    $data = json_decode($response, true);
    return $data['error'] ?? $data;
}
?>