<?php

namespace App\Database;

use PDO;
use PDOException;

class Migration
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function migrate()
    {
        $queries = [
            "DROP TABLE IF EXISTS bilhetes;",
            "DROP TABLE IF EXISTS tripulantes;", 
            "DROP TABLE IF EXISTS sorteios;",
        
            "CREATE TABLE IF NOT EXISTS tripulantes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) UNIQUE
            );",

            "INSERT INTO tripulantes (nome, email) VALUES
                ('João', 'usuario1@email.com'),
                ('Maria', 'usuario2@email.com'),
                ('José', 'usuario3@email.com');",
            
            "CREATE TABLE IF NOT EXISTS sorteios (
                id INT AUTO_INCREMENT PRIMARY KEY,
                 bilhete_premiado VARCHAR(255) NOT NULL,
                data TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );",
        
            "CREATE TABLE IF NOT EXISTS bilhetes (
                id INT AUTO_INCREMENT PRIMARY KEY,
                sorteio_id INT NOT NULL,
                tripulante_id INT NOT NULL,
                numeros VARCHAR(255) NOT NULL,
        
                FOREIGN KEY (tripulante_id) REFERENCES tripulantes(id),
                FOREIGN KEY (sorteio_id) REFERENCES sorteios(id)
            );",
        ];

        try {
            foreach ($queries as $query) {
                $this->pdo->exec($query);
            }
            echo "Migration executada com sucesso!";
        } catch (PDOException $e) {
            echo 'Falha ao executar a migration: ' . $e->getMessage();
        }
    }
}
