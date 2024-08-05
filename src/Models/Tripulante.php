<?php

namespace App\Models;

class Tripulante{    

    private \PDO $db;

    private ?string $nome = null;
    private ?string $email = null;
    
    public function __construct(\PDO $db){
        $this->db = $db;
    }

    public function getAll() :array
    {
        $query = "SELECT * FROM tripulantes";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);              
    }

    public function create() :bool
    {
        try{
            $query = "INSERT INTO tripulantes (nome, email) VALUES (:nome, :email)";
            $stmt = $this->db->prepare($query);
    
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
    
            $stmt->bindParam(":nome", $this->nome, \PDO::PARAM_STR);
            $stmt->bindParam(":email", $this->email, \PDO::PARAM_STR);

            return $stmt->execute();
            
        }catch (\PDOException $e) {
            if ($e->getCode() == '23000' && strpos($e->getMessage(), '1062 Duplicate entry') !== false) {
                throw new \Exception("Erro: O email já está cadastrado.");
            } else {
                throw new \Exception("Erro: " . $e->getMessage());
            }
        }

    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }
    
}