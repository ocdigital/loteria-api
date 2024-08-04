<?php

namespace App\Models;

class Tripulante{
    private $conn;
    private $table_name = "tripulantes";

    private $id;
    private $nome;
    private $email;
    
    public function __construct($db){
        $this->conn = $db;
    }

    public function getAll(){
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);      
        return $results;
    }

    public function create(){
        try{
            $query = "INSERT INTO " . $this->table_name . " SET nome=:nome, email=:email";
            $stmt = $this->conn->prepare($query);
    
            $this->nome=htmlspecialchars(strip_tags($this->nome));
            $this->email=htmlspecialchars(strip_tags($this->email));
    
            $stmt->bindParam(":nome", $this->nome);
            $stmt->bindParam(":email", $this->email);

            return $stmt->execute();
            
        }catch (\PDOException $e) {
            if ($e->getCode() == '23000' && strpos($e->getMessage(), '1062 Duplicate entry') !== false) {
                throw new \Exception("Erro: O email já está cadastrado.");
            } else {
                throw new \Exception("Erro: " . $e->getMessage());
            }
        }

    }

    //getters and setters
    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getNome(){
        return $this->nome;
    }

    public function setNome($nome){
        $this->nome = $nome;
    }

    public function getEmail(){
        return $this->email;
    }

    public function setEmail($email){
        $this->email = $email;
    }


    
}