<?php
$digimons = [
    [
        'id' => 1,
        'nome' => 'Agumon',
        'nivel' => 'Criança',
        'tipo' => 'Réptil',
        'atributo' => 'Vacina',
        'descricao' => 'Um dinossauro pequeno e corajoso',
        'imagem' => 'agumon.jpg'
    ],
    [
        'id' => 2,
        'nome' => 'Gabumon',
        'nivel' => 'Criança',
        'tipo' => 'Besta',
        'atributo' => 'Data',
        'descricao' => 'Mesmo usando a pele de sua mãe Garurumon ainda é um digimon do tipo réptil',
        'imagem' => 'gabumon.jpg'
    ]
    ];

    function buscarDigimonPorId($id, $digimons){
        foreach($digimons as $digimon){
            if ($digimon['id'] == $id){
                return $digimon;
            }
        }
        return null;
    }

    function filtrarDigimons($digimons, $categoria, $valor){
        return array_filter($digimons,function($digimon) use ($categoria, $valor){
            return strtolower($digimon[$categoria] == strtolower($valor));
        });
    }



?>