<?php

namespace App\Models;

use PDO;


class Sorteio{
    private $bilhete_premiado;
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function create(){
        $query = "INSERT INTO sorteios (bilhete_premiado) VALUES (:bilhete_premiado)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":bilhete_premiado", $this->bilhete_premiado);

        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function getAll(){
        $query = "SELECT * FROM sorteios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);      
        return $results;
    }

    public function getById($id){
        $query = "SELECT * FROM sorteios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);      
        return $result;
    }

    public function setBilhetePremiado($bilhete_premiado){
        $this->bilhete_premiado = $bilhete_premiado;
    }

    public function getBilhetePremiado(){
        return $this->bilhete_premiado;
    }
}