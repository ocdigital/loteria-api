<?php

namespace App\Controllers;

use App\Services\BilheteService;
use App\Validators\BilheteValidator;

class BilheteController{

    public function __construct(private BilheteService $bilheteService)
    {      
    }

    public function index(): void 
    {
        $bilhetes = $this->bilheteService->getAll();
        
        if ($bilhetes) {
            echo json_encode(array("success" => true, "bilhetes" => $bilhetes));
        } else {
            echo json_encode(array("success" => false, "message" => "Erro ao buscar bilhetes."));
        }
    }

    public function create(): void
    {       
        $data = json_decode(file_get_contents("php://input"));
        $validationResult = BilheteValidator::validate($data);

        if (!$validationResult['valid']) {
            http_response_code(400); 
            echo json_encode(array("message" => $validationResult['message']));
            return;
        }
        
        $htmlResult = $this->bilheteService->create(
            (int)$data->sorteio_id, 
            (int)$data->tripulante_id, 
            (int)$data->quantidade_dezena,
            (int)$data->quantidade_bilhete,
            $data->premiado ?? false
        );        

        if($htmlResult !== "Erro ao criar bilhete.") {
            // header("Content-Type: text/html; charset=UTF-8");
            echo $htmlResult;
        } else {
            echo json_encode(array("message" => "Não foi possível criar o bilhete."));
        }
    }   
  
}
