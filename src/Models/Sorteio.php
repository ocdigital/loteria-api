<?php

namespace App\Models;


class Sorteio{
    private ?string $bilhete_premiado = null;
    private \PDO $db;

    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function create(){
        $query = "INSERT INTO sorteios (bilhete_premiado) VALUES (:bilhete_premiado)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":bilhete_premiado", $this->bilhete_premiado, \PDO::PARAM_STR);

        try {
            return $stmt->execute();
        } catch (\PDOException $e) {           
            return false;
        }
    }

    public function getAll(): array
    {
        $query = "SELECT * FROM sorteios";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);      
        return $results;
    }

    public function getById(int $id): ?array
    {
        $query = "SELECT * FROM sorteios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(":id", $id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC) ?? null;              
    }

    public function setBilhetePremiado(string $bilhete_premiado): void
    {
        $this->bilhete_premiado = $bilhete_premiado;
    }

    public function getBilhetePremiado(): ?string
    {
        return $this->bilhete_premiado;
    }
}