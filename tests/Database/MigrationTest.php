<?php

namespace Tests\Database;

use PHPUnit\Framework\TestCase;
use App\Database\Migration;
use PDO;

class MigrationTest extends TestCase
{
    private $pdo;
    private $migration;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->migration = new Migration($this->pdo);
    }

    public function testMigrate()
    {
        $this->migration->migrate();

        $tables = ['tripulantes', 'sorteios', 'bilhetes'];
        foreach ($tables as $table) {
            $stmt = $this->pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'");
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->assertCount(1, $result, "Table $table should exist");
        }

        $stmt = $this->pdo->query("SELECT * FROM tripulantes");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $this->assertCount(3, $results, "Three initial tripulantes should be inserted");
        
        $expectedData = [
            ['nome' => 'João', 'email' => 'usuario1@email.com'],
            ['nome' => 'Maria', 'email' => 'usuario2@email.com'],
            ['nome' => 'José', 'email' => 'usuario3@email.com'],
        ];
        
        foreach ($expectedData as $index => $expected) {
            $this->assertSame($expected['nome'], $results[$index]['nome']);
            $this->assertSame($expected['email'], $results[$index]['email']);
        }
    }
}
