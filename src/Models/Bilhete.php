<?php

namespace App\Models;


class Bilhete{
    private int $sorteio_id;
    private int $tripulante_id;
    private string $numeros;
    private \PDO $db;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function create(){
        $query = "INSERT INTO bilhetes (sorteio_id, tripulante_id, numeros) 
        VALUES (:sorteio_id, :tripulante_id, :numeros)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":sorteio_id", $this->sorteio_id, \PDO::PARAM_INT);
        $stmt->bindParam(":tripulante_id", $this->tripulante_id, \PDO::PARAM_INT);
        $stmt->bindParam(":numeros", $this->numeros, \PDO::PARAM_STR);

        try {
            return $stmt->execute();
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM bilhetes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);      
        
    }
    public function getIdSorteio(): int
    {
        return $this->sorteio_id;
    }

    public function setIdSorteio(int $sorteio_id): void
    {
        $this->sorteio_id = $sorteio_id;
    }

    public function getIdTripulante(): int
    {
        return $this->tripulante_id;
    }

    public function setIdTripulante(int $tripulante_id): void
    {
        $this->tripulante_id = $tripulante_id;
    }

    public function getNumeros(): string
    {
        return $this->numeros;
    }

    public function setNumeros(string $numeros): void
    {
        $this->numeros = $numeros;
    }





}