<?php

namespace App\Services;

use App\Models\Tripulante;

class TripulanteService{

    public function __construct(private Tripulante $tripulante)
    {     
    }

    public function create($nome, $email){
        $this->tripulante->setNome($nome);
        $this->tripulante->setEmail($email);

        if($this->tripulante->create()){
            return true;
        }
        return false;
    }

    public function getAll(){        
        return $this->tripulante->getAll();
    }
}