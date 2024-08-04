<?php

namespace App\Models;


class Bilhete{
    private $id;
    private $sorteio_id;
    private $tripulante_id;
    private $numeros;
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function create(){
        $query = "INSERT INTO bilhetes (sorteio_id, tripulante_id, numeros) 
        VALUES (:sorteio_id, :tripulante_id, :numeros)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":sorteio_id", $this->sorteio_id);
        $stmt->bindParam(":tripulante_id", $this->tripulante_id);
        $stmt->bindParam(":numeros", $this->numeros);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function getAll(){
        $query = "SELECT * FROM bilhetes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);      
        return $results;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getId(){
        return $this->id;
    }

    public function setIdSorteio($sorteio_id){
        $this->sorteio_id = $sorteio_id;
    }

    public function getIdSorteio(){
        return $this->sorteio_id;
    }

    public function setIdTripulante($tripulante_id){
        $this->tripulante_id = $tripulante_id;
    }

    public function getIdTripulante(){
        return $this->tripulante_id;
    }

    public function setNumeros($numeros){
        $this->numeros = $numeros;
    }

    public function getNumeros(){
        return $this->numeros;
    }


}