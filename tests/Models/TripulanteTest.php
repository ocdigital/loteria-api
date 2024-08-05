<?php

use PHPUnit\Framework\TestCase;
use App\Models\Tripulante;

class TripulanteTest extends TestCase
{
    private $tripulante;
    private $dbMock;

    protected function setUp(): void
    {
        $this->dbMock = $this->createMock(\PDO::class);
        $this->tripulante = new Tripulante($this->dbMock);
    }

    public function testCreateSuccess()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $this->tripulante->setNome('John Doe');
        $this->tripulante->setEmail('john@example.com');
        
        $result = $this->tripulante->create();
        $this->assertTrue($result);
    }


    public function testCreateFailureDuplicateEntry()
    {
        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willThrowException(new \PDOException("O email já está cadastrado."));

        $this->tripulante->setNome('John Doe');
        $this->tripulante->setEmail('john@example.com');        

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Erro: O email já está cadastrado.");
        
        $this->tripulante->create();
        
    }

    public function testeGetAll()
    {
        $stmtMock = $this->createMock(\PDOStatement::class);
        $stmtMock->method('execute')->willReturn(true);
        $stmtMock->method('fetchAll')->willReturn([
            ['id' => 1, 'nome' => 'John Doe', 'email' => 'john@example.com'],
            ['id' => 2, 'nome' => 'Jane Doe', 'email' => 'jane@example.com'],
        ]);

        $this->dbMock->expects($this->once())
            ->method('prepare')
            ->willReturn($stmtMock);

        $result = $this->tripulante->getAll();
        $this->assertCount(2, $result);
        $this->assertEquals('John Doe', $result[0]['nome']);
        $this->assertEquals('Jane Doe', $result[1]['nome']);
    }

}
