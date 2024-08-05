<?php

namespace App\Controllers;

use App\Services\SorteioService;

class SorteioController
{ 
    public function __construct(private SorteioService $sorteioService)
    {
    }

    public function index()
    {
        $sorteios = $this->sorteioService->getAll();

        if ($sorteios) {
            echo json_encode(array("success" => true, "sorteios" => $sorteios));
        } else {
            echo json_encode(array("success" => false, "message" => "Erro ao buscar sorteios."));
        }
    }

    public function create()
    {
        if ($this->sorteioService->create()) {
            echo json_encode(array("success" => true, "message" => "Sorteio criado com sucesso!"));
        } else {
            echo json_encode(array("success" => false, "message" => "Não foi possível criar o sorteio."));
        }
    }

    public function setSorteioService($sorteioService)
    {
        $this->sorteioService = $sorteioService;
    }
}
