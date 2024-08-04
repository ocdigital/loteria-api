<?php

namespace App\Services;

use App\Models\Tripulante;

class TripulanteService{
    private $tripulante;

    public function __construct($db){
        $this->tripulante = new Tripulante($db);
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