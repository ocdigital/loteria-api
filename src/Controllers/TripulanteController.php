<?php

namespace App\Controllers;

use App\Models\Tripulante;
use App\Services\TripulanteService;

class TripulanteController {    

    public function __construct(private TripulanteService $tripulanteService) 
    {        
    }

    public function index(): void 
    {
        $tripulantes = $this->tripulanteService->getAll();
        
        if ($tripulantes) {
            echo json_encode(array("success" => true, "tripulantes" => $tripulantes));
        } else {
            echo json_encode(array("success" => false, "message" => "Erro ao buscar tripulantes."));
        }
    }

    public function create(): void 
    {
        $data = json_decode(file_get_contents("php://input")); 

        try {
            if ($this->tripulanteService->create($data->nome, $data->email)) {
                echo json_encode([
                    "success" => true, 
                    "message" => "Tripulante criado com sucesso!"
                ]);
            } else {
                echo json_encode([
                    "success" => false, 
                    "message" => "Não foi possível criar o tripulante."
                ]);
            }
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "success" => false, 
                "message" => "Erro interno: " . $e->getMessage()
            ]);
        }
    }   

}
