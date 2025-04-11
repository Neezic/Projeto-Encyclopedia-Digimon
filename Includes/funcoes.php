<?php 

function getDigimons(){
    $url = "https://digi-api.com/api/v1/digimon";
    $response = file_get_contents($url);
    return json_decode($response, true)['content'];
}
function getDigimonsPorId($id){
    $url = "https://digi-api.com/api/v1/digimon/$id";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function filtrarDigimonPorLevel($level){
    $url = "https://digi-api.com/api/v1/digimon?level=$level";
    $response = file_get_contents($url);
    return json_decode($response,true)['content'];
}


?>